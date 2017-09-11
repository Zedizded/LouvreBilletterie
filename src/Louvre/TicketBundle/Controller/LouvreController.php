<?php

namespace Louvre\TicketBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Stripe\Stripe;
use Stripe\Charge;
use Stripe\Error\Card;
use Louvre\TicketBundle\Entity\Booking;
use Louvre\TicketBundle\Entity\Visitors;
use Louvre\TicketBundle\Form\Type\BookingType;
use Louvre\TicketBundle\Form\Type\VisitorsType;
  

class LouvreController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        return $this->render('LouvreTicketBundle:Louvre:index.html.twig');
    }

    /**
     * @Route("/booking", name="booking")
     */
    public function bookingAction(Request $request)
    {
        $booking = new Booking();
        $form = $this->get('form.factory')->create(BookingType::class, $booking);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $booking->setTotalPrice(0);
            $number = 5;
            $bookingCodeService = $this->get('louvre_ticket.bookingcode');
            $ref = $bookingCodeService->bookingCodeGen($number);
            $booking->setCommandReference($ref);
            $em->persist($booking);
            $em->flush();

            return $this->redirectToRoute('booking_visitors/id', array('id' => $booking->getId()));
        }

        return $this->render('LouvreTicketBundle:Louvre:booking.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    
    /**
     * @Route("/booking/visitors/{id}", name="booking_visitors/id")
     */
    public function visitorsAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $booking = $em->getRepository('LouvreTicketBundle:Booking')->find($id);
        $nbVisitors = $booking->getTotalNbTickets();
        $ticketDate = $booking->getTicketDate();

        for($i = 1 ; $i <= $nbVisitors; $i++) {
            ${'B' . $id . 'V' . $i} = new Visitors();
            ${'B' . $id . 'V' . $i}->setIdentification('B' . $id . 'V' . $i);
            ${'B' . $id . 'V' . $i}->setBooking($booking);
            ${'B' . $id . 'V' . $i}->setTicketDate($ticketDate);
            ${'B' . $id . 'V' . $i}->setTicketPrice(0);
            $booking->addVisitor(${'B' . $id . 'V' . $i});
        }

        $form = $this->get('form.factory')->create(VisitorsType::class, $booking);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $number = 10;
            $bookingCodeService = $this->get('louvre_ticket.bookingcode');
            $ref = $bookingCodeService->bookingCodeGen($number);
            $ref = substr(${'B' . $id . 'V1'}->getVisitorName(), 0, 1) . substr(${'B' . $id . 'V1'}->getVisitorFirstName(), 0, 1) . $ref;
            $booking->setCommandReference($ref);
            $em->persist($booking);
            $visitors = $booking->getVisitors();
            $priceCounting = $this->get('louvre_ticket.ticketprice');

            foreach($visitors as $visitor) {
                $em->persist($visitor);
                $em->flush();
                $ticketPrice = $priceCounting->priceCounting($visitor);
                $visitor->setTicketPrice($ticketPrice);
                $em->persist($visitor);
            }


            $totalPrice = $priceCounting->totalCounting($booking);
            $booking->setTotalPrice($totalPrice);

            $em->flush();

            return $this->redirectToRoute('booking_order/id', array('id' => $booking->getId()));
        }

        return $this->render('LouvreTicketBundle:Louvre:visitors.html.twig', array(
            'form' => $form->createView(),
            'nbVisitors' => $nbVisitors,
            'bookingId' => $id
        ));
    }
    
    /**
     * @Route("/booking/order/{id}", name="booking_order/id")
     */
    public function orderAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $booking = $em->getRepository('LouvreTicketBundle:Booking')->find($id);

        return $this->render('LouvreTicketBundle:Louvre:order.html.twig', array(
            'booking' => $booking,
            'bookingId' => $id
        ));
    }    
    
    /**
     * @Route("/booking/checkout/{id}", name="booking_checkout")
     */
    public function checkoutAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $booking = $em->getRepository('LouvreTicketBundle:Booking')->find($id);
        $price = $booking->getTotalPrice();
        Stripe::setApiKey('sk_test_bIqywos1NSzduIuVfRIWCmzn');

        $token = $_POST['stripeToken'];

        try {
            $charge = Charge::create(array(
                'amount' => $price * 100,
                'currency' => 'eur',
                'source' => $token,
                'description' => 'Paiement Stripe - Réservation Louvre'
            ));
                        
            $Mailer = $this->get('louvre_ticket.sendingmail');
            $Mailer->send($booking);
            
            $this->addFlash('success','Paiement accepté, vous allez recevoir un email de confirmation de votre achat.');
            return $this->redirectToRoute('homepage');
            
        } catch(Card $e) {
            $this->addFlash('danger','Paiement refusé.');
            return $app->redirect($_SERVER['HTTP_REFERER']);;
        }
        
        return $this->render('LouvreTicketBundle:Louvre:index.html.twig');
    }
    
    /**
     * @Route("/booking/cancel/{id}", name="booking_cancel")
     */
    public function cancelAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $booking = $em->getRepository('LouvreTicketBundle:Booking')->find($id);

        $em->remove($booking);
        $em->flush();

        $request->getSession()->getFlashBag()->add('success', 'Votre commande a bien été annulée.');

        return $this->redirectToRoute('homepage');
    }  

}
