<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * File
 *
 * @ORM\Table(name="file")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FileRepository")
 */
class File
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
     * @ORM\ManyToMany(targetEntity="Person", inversedBy="files")
     * @ORM\JoinTable(name="files_persons")
     */
    private $persons;

    /**
     * Many Families have Many files.
     * @ORM\ManyToMany(targetEntity="Family", inversedBy="files")
     * @ORM\JoinTable(name="files_families")
     */
    private $families;

    public function __construct()
    {
        $this->persons = new ArrayCollection();
        $this->families = new ArrayCollection();
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
     * Set title
     *
     * @param string $title
     *
     * @return File
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set path
     *
     * @param string $path
     *
     * @return File
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Get the value of families
     */
    public function getFamilies()
    {
        return $this->families;
    }

    /**
     * Add the family
     *
     * @return  self
     */
    public function addFamily($family)
    {
        $family->addFile($this);
        $this->families[] = $family;

        return $this;
    }

    /**
     * Get persons
     */ 
    public function getPersons()
    {
        return $this->persons;
    }

    /**
     * Add the person
     *
     * @return  self
     */
    public function addPerson($person)
    {
        $person->addFile($this);
        $this->persons[] = $person;

        return $this;
    }
}
