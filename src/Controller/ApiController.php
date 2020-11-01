<?php

namespace App\Controller;

use App\Entity\Family;
use App\Entity\Person;
use App\Normalizer\FamilyNormalizer;
use App\Normalizer\PersonNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

class ApiController extends AbstractController
{
    /**
     * @Route("api/person/{id}")
     * @param Person $person
     * @return JsonResponse
     * @throws ExceptionInterface
     */
    public function getPersonAction(Person $person)
    {
        $data = (new PersonNormalizer())->normalize($person);

        return $this->json($data);
    }

    /**
     * @Route("api/family/{id}")
     * @param Family $family
     * @return JsonResponse
     * @throws ExceptionInterface
     */
    public function getFamilyAction(Family $family)
    {
        $data = (new FamilyNormalizer())->normalize($family);

        return $this->json($data);
    }
}
