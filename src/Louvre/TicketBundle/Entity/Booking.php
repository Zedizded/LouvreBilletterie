<?php

namespace Louvre\TicketBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Louvre\TicketBundle\Entity\Visitors;
use Louvre\TicketBundle\Validator\CheckDate;
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
     * @var \DateTime
     *
     * @ORM\Column(name="commandDate", type="date")
     */
    private $commandDate;

   /**
     * @ORM\OneToMany(targetEntity="Louvre\TicketBundle\Entity\Visitors", mappedBy="booking", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $visitors;

   /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     *
     * @Assert\NotBlank(message="Saisissez votre email")
     * @Assert\Email(message="L'email '{{ value }}' n'est pas valide.", checkMX = true)
     */
    private $email;

   /**
     * @var bool
     *
     * @ORM\Column(name="ticketType", type="boolean")
     */
    private $ticketType;

   /**
     * @var \DateTime
     *
     * @ORM\Column(name="ticketDate", type="date")
     *
     * @Assert\NotBlank(message="Saisissez la date de votre visite")
     * @Assert\Date(message="Cette date n'est pas valide")
     * @Assert\GreaterThanOrEqual(value="today", message="Vous ne pouvez plus réserver pour cette date.")
     *
     * @CheckDate()
     */
    private $ticketDate;

   /**
     * @var int
     *
     * @ORM\Column(name="totalNbTickets", type="integer")
     *
     * @Assert\NotBlank(message="Saisissez le nombre de billet(s) souhaité(s)")
     * @Assert\GreaterThanOrEqual(value="1", message="Vous devez choisir un billet minimum")
     */
    private $totalNbTickets;

   /**
     * @var string
     *
     * @ORM\Column(name="commandReference", type="string", length=255, unique=true)
     */
    private $commandReference;

   /**
     * @var int
     *
     * @ORM\Column(name="totalPrice", type="integer")
     */
    private $totalPrice;

   /**
     * Constructor
     */
    public function __construct()
    {
        $this->commandDate = new \Datetime();
        $this->visitors = new ArrayCollection();
    }

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
     * Set commandDate
     *
     * @param \DateTime $commandDate
     *
     * @return Booking
     */
    public function setCommandDate($commandDate)
    {
        $this->commandDate = $commandDate;

        return $this;
    }

   /**
     * Get commandDate
     *
     * @return \DateTime
     */
    public function getCommandDate()
    {
        return $this->commandDate;
    }

   /**
     * Add visitor
     *
     * @param Visitors $visitor
     *
     * @return Booking
     */
    public function addVisitor(Visitors $visitor)
    {
        $this->visitors[] = $visitor;

        return $this;
    }

   /**
     * Remove visitor
     *
     * @param Visitors $visitor
     */
    public function removeVisitor(Visitors $visitor)
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
     * Set email
     *
     * @param string $email
     *
     * @return Booking
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

   /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

   /**
     * Set ticketType
     *
     * @param boolean $ticketType
     *
     * @return Booking
     */
    public function setTicketType($ticketType)
    {
        $this->ticketType = $ticketType;

        return $this;
    }

   /**
     * Get ticketType
     *
     * @return bool
     */
    public function getTicketType()
    {
        return $this->ticketType;
    }

   /**
     * Set ticketDate
     *
     * @param \DateTime $ticketDate
     *
     * @return Booking
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
     * Set totalNbTickets
     *
     * @param integer $totalNbTickets
     *
     * @return Booking
     */
    public function setTotalNbTickets($totalNbTickets)
    {
        $this->totalNbTickets = $totalNbTickets;

        return $this;
    }

   /**
     * Get totalNbTickets
     *
     * @return int
     */
    public function getTotalNbTickets()
    {
        return $this->totalNbTickets;
    }

   /**
     * Set commandReference
     *
     * @param string $commandReference
     *
     * @return Booking
     */
    public function setCommandReference($commandReference)
    {
        $this->commandReference = $commandReference;

        return $this;
    }

   /**
     * Get commandReference
     *
     * @return string
     */
    public function getCommandReference()
    {
        return $this->commandReference;
    }

   /**
     * Set totalPrice
     *
     * @param integer $totalPrice
     *
     * @return Booking
     */
    public function setTotalPrice($totalPrice)
    {
        $this->totalPrice = $totalPrice;

        return $this;
    }

   /**
     * Get totalPrice
     *
     * @return int
     */
    public function getTotalPrice()
    {
        return $this->totalPrice;
    }
}