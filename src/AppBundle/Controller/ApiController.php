<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Family;
use AppBundle\Entity\Person;
use AppBundle\Normalizer\FamilyNormalizer;
use AppBundle\Normalizer\PersonNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class ApiController extends Controller
{
    /**
     * @Route("api/person/{id}")
     */
    public function getPersonAction(Person $person)
    {

        $data = (new PersonNormalizer())->normalize($person);

        return $this->json($data);
    }

    /**
     * @Route("api/family/{id}")
     */
    public function getFamilyAction(Family $family)
    {
        $data = (new FamilyNormalizer())->normalize($family);


        return $this->json($data);
    }

}
