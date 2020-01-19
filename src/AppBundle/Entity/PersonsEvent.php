<?php

namespace AppBundle\Entity;

use AppBundle\Entity\AbstractEvent;
use AppBundle\Entity\Person;
use Doctrine\ORM\Mapping as ORM;

/**
 * PersonsEvent
 *
 * @ORM\Table(name="persons_event")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PersonsEventRepository")
 */
class PersonsEvent extends AbstractEvent
{
    /**
     * Person
     * @ORM\ManyToOne(targetEntity="Person", inversedBy="events")
     * @ORM\JoinColumn(name="person_id", referencedColumnName="id", nullable=true)
     */
    private $person;

    /**
     * Get person
     */
    public function getPerson()
    {
        return $this->person;
    }

    /**
     * Set person
     *
     * @return  self
     */
    public function setPerson(Person $person)
    {
        $this->person = $person;

        return $this;
    }
}
