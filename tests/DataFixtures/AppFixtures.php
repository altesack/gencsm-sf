<?php

namespace App\Tests\DataFixtures;

use App\Entity\Family;
use App\Entity\Person;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $person1 = (new Person())->setGivn('Veit')->setSurn('Bach')->setSex('m');
        $person2 = (new Person())->setGivn('Johannes Hans')->setSurn('Bach')->setSex('m');
        $family = (new Family())->setHusband($person1)->addChildren($person2);
        $manager->persist($person1);
        $manager->persist($person2);
        $manager->persist($family);
        $manager->flush();
    }
}
