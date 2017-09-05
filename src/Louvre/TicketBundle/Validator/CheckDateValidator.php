<?php

namespace Louvre\TicketBundle\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\HttpFoundation\Request;

class CheckDateValidator extends ConstraintValidator
{
    public function validate($date, Constraint $constraint)
    {
        if(!$date instanceof \DateTime) {
            $this->context->addViolation($constraint->messageInvalidDate);
        }

        $dateDay = $date->format('D');
        $dateMonth = $date->format('d/m');
        $dateYear = $date->format('d/m/Y');
        $today = date('d/m/Y');
        $now = date('H:i:s');
        
        $request = Request::createFromGlobals();
        $post = $request->request->get('louvre_ticketbundle_booking');
        
        if($post !== null)
        {
            $ticketType = $post['ticketType'];
            if($today == $dateYear && strcmp($now, '14:00:00') > 0 && $ticketType == 1) {
                $this->context->addViolation($constraint->messageDay);
            }
        }

        if($dateDay == 'Sun') {
            $this->context->addViolation($constraint->messageSun);
        }
        
        elseif($dateDay == 'Tue') {
            $this->context->addViolation($constraint->messageTue);
        }
        
        elseif($dateMonth == '01/05') {
            $this->context->addViolation($constraint->messageMay);
        }
        
        elseif($dateMonth == '01/11') {
            $this->context->addViolation($constraint->messageNov);
        }
        
        elseif($dateMonth == '25/12') {
            $this->context->addViolation($constraint->messageDec);
        }
    }
}