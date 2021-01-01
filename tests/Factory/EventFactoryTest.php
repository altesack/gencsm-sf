<?php

namespace App\Tests\Factory;

use App\Entity\Family;
use App\Entity\Person;
use App\Factory\EventFactory;
use App\Tests\CreateTestDataTestCase;

class EventFactoryTest extends CreateTestDataTestCase
{
    public function testCreatePersonsEvent()
    {
        /** @var EventFactory $eventFactory */
        $eventFactory = self::$kernel->getContainer()->get('App\Factory\EventFactory');

        $person = (new Person())->setSurn('Bach')->setGivn('Johann Michael');
        $this->entityManager->persist($person);
        $this->entityManager->flush();
        $this->assertEquals(0, $person->getEvents()->count());
        $eventFactory->createPersonsEvent($person, 'BIRT', '1648');
        $this->assertEquals(1, $person->getEvents()->count());
    }

    public function testCreateFamilyEvent()
    {
        /** @var EventFactory $eventFactory */
        $eventFactory = self::$kernel->getContainer()->get('App\Factory\EventFactory');

        $person1 = (new Person())->setSurn('Bach')->setGivn('Johann Sebastian');
        $person2 = (new Person())->setSurn('Wilcke')->setGivn('Anna Magdalena');
        $this->entityManager->persist($person1);
        $this->entityManager->persist($person2);
        $family = (new Family())->setHusband($person1)->setWife($person2);
        $this->entityManager->persist($family);
        $this->entityManager->flush();
        $this->assertEquals(0, $family->getEvents()->count());

        $eventFactory->createFamilyEvent($family, 'MARR', '03 DEC 1721');
        $this->assertEquals(1, $family->getEvents()->count());
    }
}
