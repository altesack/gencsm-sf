<?php


namespace App\Factory;

use App\Entity\Place;
use Doctrine\ORM\EntityManagerInterface;

class PlaceFactory
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function createPlace(string $title)
    {
        $place = (new Place())->setTitle($title);
        $this->em->persist($place);
        $this->em->flush();

        return $place;
    }
    public function findOrCreatePlace(string $title = null)
    {
        if (!$title) {
            return null;
        }
        $place = $this->em->getRepository(Place::class)->findOneByTitle($title);
        if (!$place) {
            $place = $this->createPlace($title);
        }

        return $place;
    }
}
