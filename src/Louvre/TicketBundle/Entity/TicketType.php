<?php

namespace Louvre\TicketBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TicketType
 *
 * @ORM\Table(name="ticket_type")
 * @ORM\Entity(repositoryClass="Louvre\TicketBundle\Repository\TicketTypeRepository")
 */
class TicketType
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
     * @ORM\Column(name="normal", type="integer")
     */
    private $normal;

    /**
     * @var int
     *
     * @ORM\Column(name="child", type="integer")
     */
    private $child;

    /**
     * @var int
     *
     * @ORM\Column(name="senior", type="integer")
     */
    private $senior;

    /**
     * @var int
     *
     * @ORM\Column(name="reduced", type="integer")
     */
    private $reduced;


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
     * Set normal
     *
     * @param integer $normal
     *
     * @return TicketType
     */
    public function setNormal($normal)
    {
        $this->normal = $normal;

        return $this;
    }

    /**
     * Get normal
     *
     * @return int
     */
    public function getNormal()
    {
        return $this->normal;
    }

    /**
     * Set child
     *
     * @param integer $child
     *
     * @return TicketType
     */
    public function setChild($child)
    {
        $this->child = $child;

        return $this;
    }

    /**
     * Get child
     *
     * @return int
     */
    public function getChild()
    {
        return $this->child;
    }

    /**
     * Set senior
     *
     * @param integer $senior
     *
     * @return TicketType
     */
    public function setSenior($senior)
    {
        $this->senior = $senior;

        return $this;
    }

    /**
     * Get senior
     *
     * @return int
     */
    public function getSenior()
    {
        return $this->senior;
    }

    /**
     * Set reduced
     *
     * @param integer $reduced
     *
     * @return TicketType
     */
    public function setReduced($reduced)
    {
        $this->reduced = $reduced;

        return $this;
    }

    /**
     * Get reduced
     *
     * @return int
     */
    public function getReduced()
    {
        return $this->reduced;
    }
}

