<?php

namespace Louvre\TicketBundle\Services;

class BookingCode
{
    public function bookingCodeGen($number) {
        $ref = date('dmy') . ' | ';
        $string = 'A0B1C2D3E4F5G6H7I8J9K0L1M2N3O4P5Q6R7S8U9T0V4W5X6Y7Z5a6b7c8d9e0f1g2h3i4j5k6l7m8n9o0p1q2r3s4t5u6v7w8x9y0z1';
        $nbChars = strlen($string);

        for($i = 0; $i < $number; $i++)
        {
            $ref .= $string[rand(0, ($nbChars-1))];
        }

        return $ref;
    }
}