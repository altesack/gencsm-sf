<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Bridge\Doctrine\IdGenerator\UuidV4Generator;

/**
 * Family.
 *
 * @ORM\Table(name="families")
 * @ORM\Entity(repositoryClass="App\Repository\FamilyRepository")
 */
class Family
{
    use TimestampableEntity;

    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class=UuidV4Generator::class)
     */
    private $id;

    /**
     * Husband. Persons can be marries more than one time.
     *
     * @var Person
     * @ORM\ManyToOne(targetEntity="Person", inversedBy="husbandInFamilies", cascade={"persist"})
     * @ORM\JoinColumn(name="husband_id", referencedColumnName="id", nullable=true)
     */
    private $husband;

    /**
     * Wife. Persons can be marries more than one time.
     *
     * @var Person
     * @ORM\ManyToOne(targetEntity="Person", inversedBy="wifeInFamilies", cascade={"persist"})
     * @ORM\JoinColumn(name="wife_id", referencedColumnName="id", nullable=true)
     */
    private $wife;

    /**
     * One family can have many children.
     *
     * @ORM\OneToMany(targetEntity="Person", mappedBy="bornInFamily")
     */
    private $children;

    /**
     * Family events.
     *
     * @var FamilyEvent
     * @ORM\OneToMany(targetEntity="FamilyEvent", mappedBy="family")
     */
    private $events;

    /**
     * Files.
     *
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
     * Get id.
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set husband.
     *
     * @param Person|null $husband
     *
     * @return Family
     */
    public function setHusband(Person $husband = null): Family
    {
        $this->husband = $husband;

        return $this;
    }

    /**
     * Get husband.
     *
     * @return Person
     */
    public function getHusband(): ?Person
    {
        return $this->husband;
    }

    /**
     * Set wife.
     *
     * @param Person|null $wife
     *
     * @return Family
     */
    public function setWife(Person $wife = null): Family
    {
        $this->wife = $wife;

        return $this;
    }

    /**
     * Get wife.
     */
    public function getWife(): ?Person
    {
        return $this->wife;
    }

    /**
     * Get children.
     */
    public function getChildren(): Collection
    {
        return $this->children;
    }

    /**
     * Add children.
     *
     * @param Person $person
     *
     * @return self
     */
    public function addChildren(Person $person): Family
    {
        if (!$this->children->contains($person)) {
            $this->children[] = $person;
            $person->setBornInFamily($this);
        }

        return $this;
    }

    /**
     * Get files.
     */
    public function getFiles(): Collection
    {
        return $this->files;
    }

    /**
     * Add file.
     *
     * @param File $file
     *
     * @return self
     */
    public function addFile(File $file): Family
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
     * Add event.
     *
     * @param FamilyEvent $event
     *
     * @return self
     */
    public function addEvent(FamilyEvent $event): Family
    {
        if (!$this->events->contains($event)) {
            $this->events[] = $event;
            $event->setFamily($this);
        }

        return $this;
    }
}
