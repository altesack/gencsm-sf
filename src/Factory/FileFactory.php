<?php

namespace App\Factory;

use App\Entity\Family;
use App\Entity\File;
use App\Entity\Person;
use Doctrine\ORM\EntityManagerInterface;

class FileFactory
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function addFileToPerson(Person $person, string $path, string $title)
    {
        $file = $this->findOrCreateFile($path, $title);
        $file->addPerson($person);

        $this->em->flush();
    }

    public function addFileToFamily(Family $family, string $path, string $title)
    {
        $file = $this->findOrCreateFile($path, $title);
        $file->addFamily($family);

        $this->em->flush();
    }

    /**
     * findOrCreateFile.
     *
     * @param string $path
     * @param string $title
     *
     * @return File
     */
    protected function findOrCreateFile(string $path, string $title)
    {
        $file = $this->em->getRepository(File::class)->findOneByPath($path);
        if (!$file) {
            $file = (new File())
                ->setTitle($title)
                ->setPath($path);
            $this->em->persist($file);
            $this->em->flush();
        }

        return $file;
    }
}
