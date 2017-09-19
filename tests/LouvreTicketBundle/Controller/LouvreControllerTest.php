<?php

namespace Louvre\tests\LouvreTicketBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LouvreControllerTest extends WebTestCase
{
    public function testIndexAndLinks()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertContains('Bienvenue', $client->getResponse()->getContent());

        $infosLink = $crawler->filter('p.lead a');
        $crawler = $client->click($infosLink->link());

        $this->assertContains('Le tarif "journée" est de :', $client->getResponse()->getContent());

        $bookingLink = $crawler->filter('p a');
        $crawler = $client->click($bookingLink->link());

        $this->assertEquals(1, $crawler->filter('h1:contains("Réservation")')->count());
    }

    public function testBookingForm()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/booking');

        $form = $crawler->selectButton('Continuer')->form();
        $crawler = $client->submit($form, array(
            'louvre_ticketbundle_booking[ticketDate]'        => '30/10/2017',
            'louvre_ticketbundle_booking[email]'             => 'matt.halwani@gmail.com',
            'louvre_ticketbundle_booking[ticketType]'        => true,
            'louvre_ticketbundle_booking[totalNbTickets]'    => '5'
        ));

        $this->assertEquals('Louvre\TicketBundle\Controller\LouvreController::bookingAction', $client->getRequest()->attributes->get('_controller'));
    }
}