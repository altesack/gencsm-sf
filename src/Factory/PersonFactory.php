<?php


namespace App\Factory;

use App\Entity\Person;
use Doctrine\ORM\EntityManagerInterface;
use PhpGedcom\Record\Date;
use PhpGedcom\Record\Fam\Even;
use PhpGedcom\Record\Indi;

class PersonFactory
{
    private $em;
    private $placeFactory;
    private $eventFactory;

    public function __construct(EntityManagerInterface $em, PlaceFactory $placeFactory, EventFactory $eventFactory)
    {
        $this->em = $em;
        $this->placeFactory = $placeFactory;
        $this->eventFactory = $eventFactory;
    }

    public function createPerson(string $givn = null, string $surn = null, string $sex = null, string $gedcomId = null)
    {
        $person = (new Person())
            ->setGivn($givn)
            ->setSurn($surn)
            ->setSex($sex)
            ->setGedcomId($gedcomId);
        $this->em->persist($person);
        $this->em->flush();

        return $person;
    }

    public function createPersonFromIndi(Indi $individual)
    {
        $gedcomId = $individual->getId();
        $surn = current($individual->getName())->getSurn();
        $givn = current($individual->getName())->getGivn();
        $name = current($individual->getName())->getName();
        $sex = $individual->getSex();
        if ($givn == '') {
            $givn = $name;
        }
        $person = $this->createPerson($givn, $surn, $sex, $gedcomId);

        $this->addEventsToPerson($individual->getAllEven(), $person);
        $this->addAttributesToPerson($individual->getAllAttr(), $person);

        $media = $individual->getObje();
        foreach ($media as $mediaFile) {
            $this->addFileToPerson($person, $mediaFile->getTitl(), $mediaFile->getFile()); //TODO to be implemented
        }
    }

    /**
     * @param Even[] $events
     * @param Person $person
     */
    protected function addEventsToPerson(array $events, Person $person): void
    {
        if (!$events) {
            return;
        }

        foreach ($events as $event) {
            $event = $event[0];
            /** @var Date $date */
            $date = $event->getDate()->getDate(); // TODO something should be done with it
            $place = $this->placeFactory->findOrCreatePlace($event->getPlac());
            $this->eventFactory->createPersonsEvent($person, $event->getType(), $date, $place);
        }
    }

    /**
     * @param array  $attr
     * @param Person $person
     */
    protected function addAttributesToPerson(array $attr, Person $person): void
    {
        if (!$attr) {
            return;
        }

        foreach ($attr as $event) {
            $date = $event->getDate();
            $place = $this->placeFactory->findOrCreatePlace($event->getPlac());
            $note = '';
            if (count($event->getNote()) > 0) {
                $note = current($event->getNote())->getNote();
            }
            $this->eventFactory->createPersonsEvent($person, $event->getType(), $date, $place, $note);
        }
    }
}
