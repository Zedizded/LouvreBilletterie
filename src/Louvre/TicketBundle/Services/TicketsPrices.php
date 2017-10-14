<?php

namespace Louvre\TicketBundle\Services;

use Doctrine\ORM\EntityManager;

class TicketsPrices
{
    private $em = null;
    private $youngprice;
    private $teenprice;
    private $normalprice;
    private $seniorprice;
    private $reduceprice;

    public function __construct(EntityManager $em, $youngprice, $teenprice, $normalprice, $seniorprice, $reduceprice)
    {
        $this->em = $em;
        $this->youngprice = $youngprice;
        $this->teenprice = $teenprice;
        $this->normalprice = $normalprice;
        $this->seniorprice = $seniorprice;
        $this->reduceprice = $reduceprice;
    }

    public function priceCounting($id)
    {
        $visitor = $this->em->getRepository('LouvreTicketBundle:Visitors')->find($id);
        $birth = $visitor->getVisitorBirth();
        $reduceTicket = $visitor->getReduceTicket();
        
        $booking = $visitor->getBooking();
        $date = $booking->getTicketDate();
        $ticketType = $booking->getTicketType();

        $age = $birth->diff($date)->format('%y');
        
        if ($age < 4) {
            $ticketPrice = $this->youngprice;
        }
        
        elseif ($age >= 4 && $age < 12) {
            $ticketPrice = $this->teenprice;
        }

        elseif ($reduceTicket == 1) {
            $ticketPrice = $this->reduceprice;
        }
        
        else {
            
            if ($age >= 12 && $age < 60) {
                $ticketPrice = $this->normalprice;
            }
            
            elseif ($age >= 60) {
                $ticketPrice = $this->seniorprice;
            }
        }
        
        if ($ticketType == 0) {
            $ticketPrice = $ticketPrice / 2;
        }

        return $ticketPrice;
    }

    public function totalCounting($id)
    {
        $booking = $this->em->getRepository('LouvreTicketBundle:Booking')->find($id);

        $visitors = $booking->getVisitors();

        $totalPrice = $booking->getTotalPrice();

        foreach ($visitors as $visitor) {
            $totalPrice += $visitor->getTicketPrice();
        }

        return $totalPrice;
    }
}