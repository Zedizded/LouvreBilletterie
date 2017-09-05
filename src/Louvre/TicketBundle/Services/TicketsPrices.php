<?php

namespace Louvre\TicketBundle\Services;

use Doctrine\ORM\EntityManager;

class TicketsPrices
{
    private $em = null;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
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

        if ($reduceTicket == 1) {
            $ticketPrice = 10;
            
        } else {
            
            if ($age < 4) {
                $ticketPrice = 0;
                
            }
            
            elseif ($age > 4 && $age < 12) {
                $ticketPrice = 8;
                
            }
            
            elseif ($age >= 12 && $age < 60) {
                $ticketPrice = 16;
                
            }
            
            elseif ($age >= 60) {
                $ticketPrice = 12;
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