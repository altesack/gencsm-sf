<?php

namespace App\Tests\Repository;

use App\Entity\Person;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PersonRepositoryTest extends KernelTestCase
//class BaseTestCase extends WebTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function testSearchByName()
    {
        $person = $this->entityManager
            ->getRepository(Person::class)
            ->findOneBy(['givn' => 'Veit'])
        ;

        $this->assertSame("Bach", $person->getSurn());
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        // doing this is recommended to avoid memory leaks
        $this->entityManager->close();
        $this->entityManager = null;
    }
}
