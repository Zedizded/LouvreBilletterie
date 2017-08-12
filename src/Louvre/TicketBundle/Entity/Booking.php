<?php

namespace Louvre\TicketBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Booking
 *
 * @ORM\Table(name="booking")
 * @ORM\Entity(repositoryClass="Louvre\TicketBundle\Repository\BookingRepository")
 */
class Booking
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var bool
     *
     * @ORM\Column(name="payment", type="boolean")
     */
    private $payment;

    /**
     * @var string
     *
     * @ORM\Column(name="reference", type="string", length=255)
     */
    private $reference;
    
    /**
     * @ORM\OneToMany(targetEntity="Louvre\TicketBundle\Entity\Visitors", mappedBy="booking", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $visitors;

    /**
     * @ORM\OneToMany(targetEntity="Louvre\TicketBundle\Entity\Ticket", mappedBy="booking", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $tickets;

    /**
     * @ORM\OneToOne(targetEntity="Louvre\TicketBundle\Entity\Date", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $commandDate;
    
    /**
     * @ORM\OneToOne(targetEntity="Louvre\TicketBundle\Entity\Date", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $bookingDate;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set payment
     *
     * @param boolean $payment
     *
     * @return Booking
     */
    public function setPayment($payment)
    {
        $this->payment = $payment;

        return $this;
    }

    /**
     * Get payment
     *
     * @return bool
     */
    public function getPayment()
    {
        return $this->payment;
    }

    /**
     * Set reference
     *
     * @param string $reference
     *
     * @return Booking
     */
    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * Get reference
     *
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->visitors = new \Doctrine\Common\Collections\ArrayCollection();
        $this->tickets = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add visitor
     *
     * @param \Louvre\TicketBundle\Entity\Visitors $visitor
     *
     * @return Booking
     */
    public function addVisitor(\Louvre\TicketBundle\Entity\Visitors $visitor)
    {
        $this->visitors[] = $visitor;
        
        // On lie le visiteur à la réservation
        $visitor->setBooking($this); // Voir table2.txt
        
        return $this;
    }

    /**
     * Remove visitor
     *
     * @param \Louvre\TicketBundle\Entity\Visitors $visitor
     */
    public function removeVisitor(\Louvre\TicketBundle\Entity\Visitors $visitor)
    {
        $this->visitors->removeElement($visitor);
    }

    /**
     * Get visitors
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getVisitors()
    {
        return $this->visitors;
    }

    /**
     * Add ticket
     *
     * @param \Louvre\TicketBundle\Entity\Ticket $ticket
     *
     * @return Booking
     */
    public function addTicket(\Louvre\TicketBundle\Entity\Ticket $ticket)
    {
        $this->tickets[] = $ticket;
        
        // On lie le billet à la réservation
        $ticket->setBooking($this); // Voir table2.txt

        return $this;
    }

    /**
     * Remove ticket
     *
     * @param \Louvre\TicketBundle\Entity\Ticket $ticket
     */
    public function removeTicket(\Louvre\TicketBundle\Entity\Ticket $ticket)
    {
        $this->tickets->removeElement($ticket);
    }

    /**
     * Get tickets
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTickets()
    {
        return $this->tickets;
    }

    /**
     * Set commandDate
     *
     * @param \Louvre\TicketBundle\Entity\Date $commandDate
     *
     * @return Booking
     */
    public function setCommandDate(\Louvre\TicketBundle\Entity\Date $commandDate)
    {
        $this->commandDate = $commandDate;

        return $this;
    }

    /**
     * Get commandDate
     *
     * @return \Louvre\TicketBundle\Entity\Date
     */
    public function getCommandDate()
    {
        return $this->commandDate;
    }

    /**
     * Set bookingDate
     *
     * @param \Louvre\TicketBundle\Entity\Date $bookingDate
     *
     * @return Booking
     */
    public function setBookingDate(\Louvre\TicketBundle\Entity\Date $bookingDate)
    {
        $this->bookingDate = $bookingDate;

        return $this;
    }

    /**
     * Get bookingDate
     *
     * @return \Louvre\TicketBundle\Entity\Date
     */
    public function getBookingDate()
    {
        return $this->bookingDate;
    }
}
