<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * File.
 *
 * @ORM\Table(name="files")
 * @ORM\Entity(repositoryClass="App\Repository\FileRepository")
 */
class File
{
    use TimestampableEntity;

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
     * @ORM\Column(name="title", type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="path", type="string", length=255)
     */
    private $path;

    /**
     * Many Persons have Many files.
     *
     * @ORM\ManyToMany(targetEntity="Person", inversedBy="files", cascade={"persist"})
     * @ORM\JoinTable(name="files_persons")
     */
    private $persons;

    /**
     * Many Families have Many files.
     *
     * @ORM\ManyToMany(targetEntity="Family", inversedBy="files", cascade={"persist"})
     * @ORM\JoinTable(name="files_families")
     */
    private $families;

    public function __construct()
    {
        $this->persons = new ArrayCollection();
        $this->families = new ArrayCollection();
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set title.
     *
     * @param string $title
     *
     * @return File
     */
    public function setTitle(string $title): File
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title.
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Set path.
     *
     * @param string $path
     *
     * @return File
     */
    public function setPath(string $path): File
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path.
     *
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * Get the value of families.
     */
    public function getFamilies(): ArrayCollection
    {
        return $this->families;
    }

    /**
     * Add the family.
     *
     * @param Family $family
     * @return self
     */
    public function addFamily(Family $family): File
    {
        $family->addFile($this);
        $this->families[] = $family;

        return $this;
    }

    /**
     * Get persons.
     */
    public function getPersons(): ArrayCollection
    {
        return $this->persons;
    }

    /**
     * Add the person.
     *
     * @param Person $person
     * @return self
     */
    public function addPerson(Person $person): File
    {
        $person->addFile($this);
        $this->persons[] = $person;

        return $this;
    }
}
