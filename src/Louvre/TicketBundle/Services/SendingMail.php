<?php

namespace Louvre\TicketBundle\Services;

use Louvre\TicketBundle\Entity\Booking;
use Swift_Image;

class SendingMail
{
	protected $mailer;
	protected $templating;
 
    public function __construct(\Swift_Mailer $mailer, $templating)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
    }
    
	public function send($booking)
	{
		$message = \Swift_Message::newInstance();
        $message
            ->setSubject('Votre réservation pour le Musée du Louvre')
            ->setFrom('billetterielouvre@gmail.com')
            ->setTo($booking->getEmail())
            ->setBody($this->templating->render('LouvreTicketBundle:Louvre:email.html.twig', array(
                'booking' => $booking,
                'visitors' => $booking->getVisitors(),
                'logo' => $message->embed(Swift_Image::fromPath('img/pyramide-logo3-h.png'))
            )),
            'text/html');
        $this->mailer->send($message);
	}
}