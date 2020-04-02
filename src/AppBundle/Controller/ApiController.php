<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Family;
use AppBundle\Entity\Person;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class ApiController extends Controller
{
    /**
     * @Route("api/person/{id}")
     */
    public function getPersonAction(Person $person)
    {

        $data = [
            'id' => $person->getId(),
            'name' => $person->getGivn(),
            'surname' => $person->getSurn(),
        ];

        return $this->json($data);
    }

    /**
     * @Route("api/family/{id}")
     */
    public function getFamilyAction(Family $family)
    {
        $data = [
            'id' => $family->getId(),
            // 'surname' => $family->getSurn(),
        ];

        return $this->json($data);
    }

}
