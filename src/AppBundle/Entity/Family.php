<?php

namespace AppBundle\Entity;

use AppBundle\Entity\FamilyEvent;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Family
 *
 * @ORM\Table(name="family")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FamilyRepository")
 */
class Family
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
     * Hustband. Persons can be marries more than one time
     * @ORM\ManyToOne(targetEntity="Person", inversedBy="husbandInFamilies")
     * @ORM\JoinColumn(name="husband_id", referencedColumnName="id", nullable=true)
     */
    private $husband;

    /**
     * Wife. Persons can be marries more than one time
     * @ORM\ManyToOne(targetEntity="Person", inversedBy="wifeInFamilies")
     * @ORM\JoinColumn(name="wife_id", referencedColumnName="id", nullable=true)
     */
    private $wife;

    /**
     * One family can have many children.
     * @ORM\OneToMany(targetEntity="Person", mappedBy="bornInFamily")
     */
    private $children;

    /**
     * Family events.
     * @ORM\OneToMany(targetEntity="FamilyEvent", mappedBy="family")
     */
    private $events;

    /**
     * Files.
     * @ORM\ManyToMany(targetEntity="File", mappedBy="persons")
     */
    private $files;

    public function __construct()
    {
        $this->children = new ArrayCollection();
        $this->files = new ArrayCollection();
        $this->events = new ArrayCollection();
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
     * Set husband
     *
     * @param string $husband
     *
     * @return Family
     */
    public function setHusband($husband)
    {
        $this->husband = $husband;

        return $this;
    }

    /**
     * Get husband
     *
     * @return string
     */
    public function getHusband()
    {
        return $this->husband;
    }

    /**
     * Set wife
     *
     * @param string $wife
     *
     * @return Family
     */
    public function setWife($wife)
    {
        $this->wife = $wife;

        return $this;
    }

    /**
     * Get wife
     *
     * @return string
     */
    public function getWife()
    {
        return $this->wife;
    }

    /**
     * Get children.
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Add children.
     *
     * @return  self
     */
    public function addChildren(Person $person)
    {
        $this->children[] = $person;

        return $this;
    }

    /**
     * Get files.
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * Add file.
     *
     * @return  self
     */
    public function addFiles(File $file)
    {
        $this->files[] = $file;

        return $this;
    }

    /**
     * Get events.
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * Add event
     *
     * @return  self
     */
    public function addEvent(FamilyEvent $event)
    {
        $this->events[] = $event;

        return $this;
    }
}
