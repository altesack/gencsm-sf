<?php

namespace App\Factory;

use App\Entity\Family;
use App\Entity\Person;
use App\Repository\PersonRepository;
use Doctrine\ORM\EntityManagerInterface;
use PhpGedcom\Record\Fam;
use PhpGedcom\Record\Fam\Even;

class FamilyFactory
{
    private $em;
    private $placeFactory;
    private $eventFactory;
    private $personRepository;

    public function __construct(EntityManagerInterface $em, PlaceFactory $placeFactory, EventFactory $eventFactory, PersonRepository $personRepository)
    {
        $this->em = $em;
        $this->placeFactory = $placeFactory;
        $this->eventFactory = $eventFactory;
        $this->personRepository = $personRepository;
    }

    public function createFamily(Person $husband = null, Person $wife = null)
    {
        $family = (new Family())
            ->setHusband($husband)
            ->setWife($wife);
        $this->em->persist($family);
        $this->em->flush();

        return $family;
    }

    public function createFamilyFromFam(Fam $fam)
    {
        $husband = $this->findPerson($fam->getHusb());
        $wife = $this->findPerson($fam->getWife());
        $family = $this->createFamily($husband, $wife);

        $this->addChildrenToFamily($fam->getChil(), $family);
        $this->addEventsToFamily($fam->getAllEven(), $family);
        $this->addFilesToFamily($fam->getObje(), $family);
    }

    /**
     * @param Even[] $events
     * @param Family $family
     */
    protected function addEventsToFamily($events, Family $family): void
    {
        if (!$events) {
            return;
        }
        foreach ($events as $event) {
            $date = $event->getDate();
            $place = $this->placeFactory->findOrCreatePlace($event->getPlac());
            $this->eventFactory->createFamilyEvent($family, $event->getType(), $date, $place);
        }
    }

    /**
     * @param $children
     * @param Family $family
     */
    protected function addChildrenToFamily($children, Family $family): void
    {
        if (!$children) {
            return;
        }
        foreach ($children as $child) {
            $person = $this->findPerson($child);
            $person->setBornInFamily($family);
            $this->em->flush();
        }
    }

    /**
     * @param $media
     * @param Family $family
     */
    protected function addFilesToFamily($media, Family $family): void
    {
        if (!$media) {
            return;
        }
        foreach ($media as $mediaFile) {
            $this->addFileToFamily($family, $mediaFile->getTitl(), $mediaFile->getFile());
        }
    }

    /**
     * findPerson.
     *
     * @param string|null $gedcomId
     *
     * @return Person|null
     */
    protected function findPerson(string $gedcomId = null)
    {
        return $this->personRepository->findOneByGedcomId($gedcomId);
    }
}
