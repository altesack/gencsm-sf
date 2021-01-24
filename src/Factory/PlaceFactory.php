<?php

namespace App\Factory;

use App\Entity\Place;
use App\Repository\PlaceRepository;
use Doctrine\ORM\EntityManagerInterface;

class PlaceFactory
{
    private $em;
    private $repository;

    public function __construct(EntityManagerInterface $em, PlaceRepository $repository)
    {
        $this->em = $em;
        $this->repository = $repository;
    }

    public function createPlace(string $title): Place
    {
        $place = (new Place())->setTitle($title);
        $this->em->persist($place);
        $this->em->flush();

        return $place;
    }

    public function findOrCreatePlace(string $title = null): ?Place
    {
        if (!$title) {
            return null;
        }

        $place = $this->repository->findOneByTitle($title);

        if (!$place) {
            $place = $this->createPlace($title);
        }

        return $place;
    }
}
