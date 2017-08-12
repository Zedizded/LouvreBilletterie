<?php

namespace Louvre\TicketBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tva
 *
 * @ORM\Table(name="tva")
 * @ORM\Entity(repositoryClass="Louvre\TicketBundle\Repository\TvaRepository")
 */
class Tva
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
     * @var int
     *
     * @ORM\Column(name="vatRate", type="integer")
     */
    private $vatRate;


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
     * Set vatRate
     *
     * @param integer $vatRate
     *
     * @return Tva
     */
    public function setVatRate($vatRate)
    {
        $this->vatRate = $vatRate;

        return $this;
    }

    /**
     * Get vatRate
     *
     * @return int
     */
    public function getVatRate()
    {
        return $this->vatRate;
    }
}

