<?php

namespace Louvre\TicketBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Louvre\TicketBundle\Entity\Booking;

/**
  * Visitors
  *
  * @ORM\Table(name="visitors")
  * @ORM\Entity(repositoryClass="Louvre\TicketBundle\Repository\VisitorsRepository")
  */
class Visitors
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
     * @ORM\ManyToOne(targetEntity="Louvre\TicketBundle\Entity\Booking", inversedBy="visitors", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $booking;

   /**
     * @var string
     *
     * @ORM\Column(name="identity", type="string", length=255)
     */
    private $identity;

   /**
     * @var \DateTime
     *
     * @ORM\Column(name="ticketDate", type="datetime")
     */
    private $ticketDate;

   /**
     * @var string
     *
     * @ORM\Column(name="visitorName", type="string", length=255)
     */
    private $visitorName;

   /**
     * @var string
     *
     * @ORM\Column(name="visitorFirstName", type="string", length=255)
     */
    private $visitorFirstName;

   /**
     * @var \DateTime
     *
     * @ORM\Column(name="visitorBirth", type="datetime")
     *
     * @Assert\DateTime(message="Cette date n'est pas valide")
     */
    private $visitorBirth;

   /**
     * @var string
     *
     * @ORM\Column(name="visitorCountry", type="string", length=10)
     *
     * @Assert\Country()
     */
    private $visitorCountry;

   /**
     * @var bool
     *
     * @ORM\Column(name="reduceTicket", type="boolean")
     */
    private $reduceTicket;


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
     * Set booking
     *
     * @param \Louvre\TicketBundle\Entity\Booking $booking
     *
     * @return Visitors
     */
    public function setBooking(Booking $booking)
    {
        $this->booking = $booking;

        return $this;
    }

   /**
     * Get booking
     *
     * @return \Louvre\TicketBundle\Entity\Booking
     */
    public function getBooking()
    {
        return $this->booking;
    }

   /**
     * Set name
     *
     * @param string $name
     *
     * @return Visitors
     */
    public function setIdentity($identity)
    {
        $this->identity = $identity;

        return $this;
    }

   /**
     * Get name
     *
     * @return string
     */
    public function getIdentity()
    {
        return $this->identity;
    }

   /**
     * Set ticketDate
     *
     * @param \DateTime $ticketDate
     *
     * @return Visitors
     */
    public function setTicketDate($ticketDate)
    {
        $this->ticketDate = $ticketDate;

        return $this;
    }

   /**
     * Get ticketDate
     *
     * @return \DateTime
     */
    public function getTicketDate()
    {
        return $this->ticketDate;
    }

   /**
     * Set visitorName
     *
     * @param string $visitorName
     *
     * @return Visitors
     */
    public function setVisitorName($visitorName)
    {
        $this->visitorName = $visitorName;

        return $this;
    }

   /**
     * Get visitorName
     *
     * @return string
     */
    public function getVisitorName()
    {
        return $this->visitorName;
    }

   /**
     * Set visitorFirstName
     *
     * @param string $visitorFirstName
     *
     * @return Visitors
     */
    public function setVisitorFirstName($visitorFirstName)
    {
        $this->visitorFirstName = $visitorFirstName;

        return $this;
    }

   /**
     * Get visitorFirstName
     *
     * @return string
     */
    public function getVisitorFirstName()
    {
        return $this->visitorFirstName;
    }

   /**
     * Set visitorBirth
     *
     * @param \DateTime $visitorBirth
     *
     * @return Visitors
     */
    public function setVisitorBirth($visitorBirth)
    {
        $this->visitorBirth = $visitorBirth;

        return $this;
    }

   /**
     * Get visitorBirth
     *
     * @return \DateTime
     */
    public function getVisitorBirth()
    {
        return $this->visitorBirth;
    }

   /**
     * Set visitorCountry
     *
     * @param string $visitorCountry
     *
     * @return Visitors
     */
    public function setVisitorCountry($visitorCountry)
    {
        $this->visitorCountry = $visitorCountry;

        return $this;
    }

   /**
     * Get visitorCountry
     *
     * @return string
     */
    public function getVisitorCountry()
    {
        return $this->visitorCountry;
    }

   /**
     * Set reduceTicket
     *
     * @param boolean $reduceTicket
     *
     * @return Visitors
     */
    public function setReduceTicket($reduceTicket)
    {
        $this->reduceTicket = $reduceTicket;

        return $this;
    }

   /**
     * Get reduceTicket
     *
     * @return bool
     */
    public function getReduceTicket()
    {
        return $this->reduceTicket;
    }
}