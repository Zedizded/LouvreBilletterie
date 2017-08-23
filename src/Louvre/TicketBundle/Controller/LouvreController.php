<?php

namespace Louvre\TicketBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Louvre\TicketBundle\Entity\Booking;
use Louvre\TicketBundle\Entity\Visitors;
use Louvre\TicketBundle\Form\VisitorsType;


class LouvreController extends Controller
{
    public function indexAction(Request $request)
    {
        $visitors = new Visitors();
        $form = $this->get('form.factory')->create(VisitorsType::class, $visitors);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
          $em = $this->getDoctrine()->getManager();
          $em->persist($visitors);
          $em->flush();

          $request->getSession()->getFlashBag()->add('notice', 'La réservation a bien été enregistrée.');

          return $this->redirectToRoute('louvre_ticket_homepage', array('id' => $visitors->getId()));
        }

        return $this->render('LouvreTicketBundle:Louvre:index.html.twig', array(
          'form' => $form->createView(),
        ));
        
        //$content = $this->get('templating')->render('LouvreTicketBundle:Louvre:index.html.twig');
    
        //return new Response($content);

    }
}
