<?php

namespace AppBundle\Entity;

use AppBundle\Entity\File;
use AppBundle\Entity\PersonsEvent;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Person
 *
 * @ORM\Table(name="person")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PersonRepository")
 */
class Person
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
     * @var string
     *
     * @ORM\Column(name="givn", type="string", length=255)
     */
    private $givn;

    /**
     * @var string
     *
     * @ORM\Column(name="surn", type="string", length=255, nullable=true)
     */
    private $surn;

    /**
     * @var string
     *
     * @ORM\Column(name="sex", type="string", length=1, nullable=true)
     */
    private $sex;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * Many persons could be born in the one family
     * @ORM\ManyToOne(targetEntity="Family", inversedBy="children")
     * @ORM\JoinColumn(name="born_in_family_id", referencedColumnName="id", nullable=true)
     */
    private $bornInFamily;

    /**
     * One person can married many times.
     * @ORM\OneToMany(targetEntity="Family", mappedBy="husband")
     */
    private $husbandInFamilies;

    /**
     * One person can married many times.
     * @ORM\OneToMany(targetEntity="Family", mappedBy="wife")
     */
    private $wifeInFamilies;

    /**
     * Files.
     * @ORM\ManyToMany(targetEntity="File", mappedBy="persons")
     */
    private $files;

    /**
     * Family events.
     * @ORM\OneToMany(targetEntity="FamilyEvent", mappedBy="family")
     */
    private $events;

    public function __construct()
    {
        $this->husbandInFamilies = new ArrayCollection();
        $this->wifeInFamilies = new ArrayCollection();
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
     * Set givn
     *
     * @param string $givn
     *
     * @return Person
     */
    public function setGivn($givn)
    {
        $this->givn = $givn;

        return $this;
    }

    /**
     * Get givn
     *
     * @return string
     */
    public function getGivn()
    {
        return $this->givn;
    }

    /**
     * Set surn
     *
     * @param string $surn
     *
     * @return Person
     */
    public function setSurn($surn)
    {
        $this->surn = $surn;

        return $this;
    }

    /**
     * Get surn
     *
     * @return string
     */
    public function getSurn()
    {
        return $this->surn;
    }

    /**
     * Set sex
     *
     * @param string $sex
     *
     * @return Person
     */
    public function setSex($sex)
    {
        $this->sex = $sex;

        return $this;
    }

    /**
     * Get sex
     *
     * @return string
     */
    public function getSex()
    {
        return $this->sex;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Person
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Get born family
     */
    public function getBornInFamily()
    {
        return $this->bornInFamily;
    }

    /**
     * Set born family
     *
     * @return  self
     */
    public function setBornInFamily($bornInFamily)
    {
        $this->bornInFamily = $bornInFamily;

        return $this;
    }

    /**
     * Get families where the person is husband.
     */
    public function getHusbandInFamilies()
    {
        return $this->husbandInFamilies;
    }

    /**
     * Add family where the person is husband.
     */
    public function addHusbandInFamilies(Family $family)
    {
        $this->husbandInFamilies[] = $family;

        return $this;
    }

    /**
     * Get families where the person is wife.
     */
    public function getWifeInFamilies()
    {
        return $this->wifeInFamilies;
    }

    /**
     * Add family where the person is wife.
     */
    public function addWifeInFamilies(Family $family)
    {
        $this->wifeInFamilies[] = $family;

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
    public function addEvent(PersonsEvent $event)
    {
        $this->events[] = $event;

        return $this;
    }
}
