<?php

namespace Louvre\TicketBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;


class LouvreController extends Controller
{
    public function indexAction()
    {
        $content = $this->get('templating')->render('LouvreTicketBundle:Louvre:index.html.twig');
    
        return new Response($content);

        //return $this->render('LouvreTicketBundle:Default:index.html.twig');
    }
}
