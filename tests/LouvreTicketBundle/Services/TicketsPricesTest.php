<?php

namespace Louvre\tests\LouvreTicketBundle\Services;

use DateTime;
use PHPUnit\Framework\TestCase;

class TicketsPricesTest extends TestCase
{
    public function testAge()
    {
        $birth = new DateTime('1979-07-16');
        $date = new DateTime('2017-10-30');
        $age = $dob->diff($date)->format('%y');
        $this->assertEquals(38, $age);

        return $age;
    }

    /**
     * @depends testAge
     */
    public function testPriceCounting($age)
    {
        if ($age < 4) {
            $ticketPrice = 0;
        } 
        
        elseif ($age >= 4 && $age < 12) {
            $ticketPrice = 8;
        } 
        
        elseif ($age >= 12 && $age < 60) {
            $ticketPrice = 16;
        } 
        
        elseif ($age >= 60) {
            $ticketPrice = 12;
        }
        
        $this->assertEquals(16, $ticketPrice);

        return $ticketPrice;
    }

    /**
     * @depends testTicketPrice
     */
    public function testFinalTicketPrice($ticketPrice)
    {
        $ticketType = 0;
        
        if ($ticketType == 0) {
            $ticketPrice = $ticketPrice / 2;
        }
        
        $this->assertEquals(8, $ticketPrice);
    }
}