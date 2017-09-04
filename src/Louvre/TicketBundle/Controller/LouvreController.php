<?php

namespace Louvre\TicketBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
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
     * @Route("/booking", name="louvre_booking")
     */
    public function bookingAction(Request $request)
    {
        $booking = new Booking();
        $form = $this->get('form.factory')->create(BookingType::class, $booking);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $booking->setTotalPrice(0);
            $ref = $this->bookingCodeAction(5);
            $booking->setCommandReference($ref);
            $em->persist($booking);
            $em->flush();

            return $this->redirectToRoute('louvre_booking_visitors/id', array('id' => $booking->getId()));
        }

        return $this->render('LouvreTicketBundle:Louvre:booking.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    
    /**
     * @Route("/booking/visitors/{id}", name="louvre_booking_visitors/id")
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
            $booking->addVisitor(${'B' . $id . 'V' . $i});
        }

        $form = $this->get('form.factory')->create(VisitorsType::class, $booking);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $ref = $this->bookingCodeAction(10);
            $ref = ${'B' . $id . 'V1'}->getVisitorName() . '_' . $ref;
            $booking->setCommandReference($ref);
            $em->persist($booking);
            $visitors = $booking->getVisitors();

            foreach($visitors as $visitor) {
                $em->persist($visitor);
            }

            $em->flush();

            $priceCounting = $this->get('louvre_ticket.ticketprice');
            $totalPrice = $priceCounting->totalCounting($booking);
            $booking->setTotalPrice($totalPrice);

            $em->flush();

            return $this->redirectToRoute('louvre_booking_order/id', array('id' => $booking->getId()));
        }

        return $this->render('LouvreTicketBundle:Louvre:visitors.html.twig', array(
            'form' => $form->createView(),
            'nbVisitors' => $nbVisitors,
            'bookingId' => $id));
    }
    
    /**
     * @Route("/booking/order/{id}", name="louvre_booking_order/id")
     */
    public function orderAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $booking = $em->getRepository('LouvreTicketBundle:Booking')->find($id);

        return $this->render('LouvreTicketBundle:Louvre:order.html.twig', array(
            'booking' => $booking,
            'bookingId' => $id));
    }    
    
    /**
     * @Route("/booking/cancel/{id}", name="louvre_booking_cancel")
     */
    public function cancelAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $booking = $em->getRepository('LouvreTicketBundle:Booking')->find($id);

        $em->remove($booking);
        $em->flush();

        $request->getSession()->getFlashBag()->add('success', 'Votre commande a bien été annulée.');

        return $this->redirectToRoute('louvre_homepage');
    }    
    
    /**
     * Generate the command's reference
     *
     * @param $number
     *
     * @return string
     */
    private function bookingCodeAction($number) {
        $ref = date('d/m/Y') . '_';
        $string = 'A0B1C2D3E4F5G6H7I8J9K0L1M2N3O4P5Q6R7S8U9T0V4W5X6Y7Z5a6b7c8d9e0f1g2h3i4j5k6l7m8n9o0p1q2r3s4t5u6v7w8x9y0z1';
        $nbChars = strlen($string);

        for($i = 0; $i < $number; $i++)
        {
            $ref .= $string[rand(0, ($nbChars-1))];
        }

        return $ref;
    }

}
