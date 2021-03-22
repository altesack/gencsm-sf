<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Bridge\Doctrine\IdGenerator\UuidV4Generator;

/**
 * Person.
 *
 * @ORM\Table(name="persons")
 * @ORM\Entity(repositoryClass="App\Repository\PersonRepository")
 */
class Person
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
     * @var string
     *
     * @ORM\Column(name="gedcom_id", type="string", length=255, nullable=true)
     */
    private $gedcomId;

    /**
     * Many persons could be born in the one family.
     *
     * @ORM\ManyToOne(targetEntity="Family", inversedBy="children")
     * @ORM\JoinColumn(name="born_in_family_id", referencedColumnName="id", nullable=true)
     */
    private $bornInFamily;

    /**
     * One person can married many times.
     *
     * @ORM\OneToMany(targetEntity="Family", mappedBy="husband")
     */
    private $husbandInFamilies;

    /**
     * One person can married many times.
     *
     * @ORM\OneToMany(targetEntity="Family", mappedBy="wife")
     */
    private $wifeInFamilies;

    /**
     * Files.
     *
     * @ORM\ManyToMany(targetEntity="File", mappedBy="persons")
     */
    private $files;

    /**
     * Family events.
     *
     * @ORM\OneToMany(targetEntity="PersonsEvent", mappedBy="person")
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
     * Get id.
     *
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set givn.
     *
     * @param string $givn
     *
     * @return Person
     */
    public function setGivn(string $givn): Person
    {
        $this->givn = $givn;

        return $this;
    }

    /**
     * Get givn.
     *
     * @return string
     */
    public function getGivn(): string
    {
        return $this->givn;
    }

    /**
     * Set surn.
     *
     * @param string|null $surn
     *
     * @return Person
     */
    public function setSurn(string $surn = null): Person
    {
        $this->surn = $surn;

        return $this;
    }

    /**
     * Get surn.
     *
     * @return string|null
     */
    public function getSurn(): ?string
    {
        return $this->surn;
    }

    /**
     * Set sex.
     *
     * @param string|null $sex
     *
     * @return Person
     */
    public function setSex(string $sex = null): Person
    {
        $this->sex = $sex;

        return $this;
    }

    /**
     * Get sex.
     *
     * @return string|null
     */
    public function getSex(): ?string
    {
        return $this->sex;
    }

    /**
     * Set description.
     *
     * @param string|null $description
     *
     * @return Person
     */
    public function setDescription(string $description = null): Person
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Get born family.
     */
    public function getBornInFamily(): ?Family
    {
        return $this->bornInFamily;
    }

    /**
     * Set born family.
     *
     * @param Family $bornInFamily
     *
     * @return self
     */
    public function setBornInFamily(Family $bornInFamily): Person
    {
        $this->bornInFamily = $bornInFamily;

        return $this;
    }

    /**
     * Get families where the person is husband.
     */
    public function getHusbandInFamilies(): Collection
    {
        return $this->husbandInFamilies;
    }

    /**
     * Add family where the person is husband.
     *
     * @param Family $family
     *
     * @return Person
     */
    public function addHusbandInFamilies(Family $family): Person
    {
        if (!$this->husbandInFamilies->contains($family)) {
            $this->husbandInFamilies[] = $family;
            $family->setHusband($this);
        }

        return $this;
    }

    /**
     * Get families where the person is wife.
     */
    public function getWifeInFamilies(): Collection
    {
        return $this->wifeInFamilies;
    }

    /**
     * Add family where the person is wife.
     *
     * @param Family $family
     *
     * @return Person
     */
    public function addWifeInFamilies(Family $family): Person
    {
        if (!$this->wifeInFamilies->contains($family)) {
            $this->wifeInFamilies[] = $family;
            $family->setWife($this);
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
    public function addFile(File $file): Person
    {
        $this->files[] = $file;

        return $this;
    }

    /**
     * Get events.
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    /**
     * Add event.
     *
     * @param PersonsEvent $event
     *
     * @return self
     */
    public function addEvent(PersonsEvent $event): Person
    {
        if (!$this->events->contains($event)) {
            $this->events[] = $event;
            $event->setPerson($this);
        }

        return $this;
    }

    /**
     * @return string|null
     */
    public function getGedcomId(): ?string
    {
        return $this->gedcomId;
    }

    /**
     * @param string|null $gedcomId
     *
     * @return Person
     */
    public function setGedcomId(string $gedcomId = null): Person
    {
        $this->gedcomId = $gedcomId;

        return $this;
    }
}
