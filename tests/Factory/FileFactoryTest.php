<?php

namespace App\Tests\Factory;

use App\Entity\Family;
use App\Entity\Person;
use App\Factory\FileFactory;
use App\Tests\CreateTestDataTestCase;

class FileFactoryTest extends CreateTestDataTestCase
{
    public function testFindOrCreateFile()
    {
        /** @var FileFactory $fileFactory */
        $fileFactory = self::$kernel->getContainer()->get('App\Factory\FileFactory');

        $file = $fileFactory->findOrCreateFile("path/to/photo", "Photo description");
        //Should create new object
        $this->assertEquals(1, $file->getId());
        $this->assertEquals("path/to/photo", $file->getPath());
        $this->assertEquals("Photo description", $file->getTitle());

        $file = $fileFactory->findOrCreateFile("path/to/photo", "Some other description");
        // Should find the same object
        $this->assertEquals(1, $file->getId());
        $this->assertEquals("path/to/photo", $file->getPath());
        $this->assertEquals("Photo description", $file->getTitle());
    }

    public function testAddFileToPerson()
    {
        /** @var FileFactory $fileFactory */
        $fileFactory = self::$kernel->getContainer()->get('App\Factory\FileFactory');

        $person = (new Person())->setSurn('Bach')->setGivn('Heinrich');
        $this->entityManager->persist($person);
        $this->assertEquals(0, $person->getFiles()->count());

        $fileFactory->addFileToPerson($person, 'another/path', 'Another Photo description');
        $this->assertEquals(1, $person->getFiles()->count());
    }

    public function testAddFileToFamily()
    {
        /** @var FileFactory $fileFactory */
        $fileFactory = self::$kernel->getContainer()->get('App\Factory\FileFactory');

        $person = (new Person())->setSurn('Bach')->setGivn('Johann Christoph');
        $family = (new Family())->setHusband($person);
        $this->entityManager->persist($person);
        $this->entityManager->persist($family);

        $this->assertEquals(0, $family->getFiles()->count());

        $fileFactory->addFileToFamily($family, 'another/path', 'Another Photo description');
        $this->assertEquals(1, $family->getFiles()->count());
    }
}
