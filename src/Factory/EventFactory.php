<?php

namespace App\Factory;

use App\Entity\Family;
use App\Entity\FamilyEvent;
use App\Entity\Person;
use App\Entity\PersonsEvent;
use App\Entity\Place;
use Doctrine\ORM\EntityManagerInterface;

class EventFactory
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function createPersonsEvent(
        Person $person,
        string $type,
        string $date = null,
        Place $place = null,
        string $description = ''
    ) {
        $event = (new PersonsEvent())
            ->setPerson($person)
            ->setTitle($type)
            ->setDescription($description)
            ->setDate($date)
            ->setPlace($place);
        $this->em->persist($event);
        $this->em->flush();

        return $event;
    }

    public function createFamilyEvent(
        Family $family,
        string $type,
        string $date = null,
        Place $place = null,
        string $description = ''
    ) {
        $event = (new FamilyEvent())
            ->setFamily($family)
            ->setTitle($type)
            ->setDescription($description)
            ->setDate($date)
            ->setPlace($place);
        $this->em->persist($event);
        $this->em->flush();

        return $event;
    }
}
