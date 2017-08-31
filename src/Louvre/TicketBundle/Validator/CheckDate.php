<?php

namespace Louvre\TicketBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
* @Annotation
*/
class CheckDate extends Constraint
{
    public $messageInvalidDate = "Cette date n'est pas valide.";
    
    public $messageSun = "Il n'est pas possible de réserver pour le dimanche.";
    
    public $messageTue = "Fermeture hebdomadaire le mardi.";
    
    public $messageMay = "Le musée est fermé le 1er mai.";
    
    public $messageNovember = "Le musée est fermé le 1er novembre.";
    
    public $messageXmas = "Le musée est fermé le 25 décembre.";
    
    public $messageDay = "Vous ne pouvez plus acheter de billet journée après 14h.";
}