<?php

namespace App\Factory;

use App\Entity\Family;
use App\Entity\File;
use App\Entity\Person;
use App\Repository\FileRepository;
use Doctrine\ORM\EntityManagerInterface;

class FileFactory
{
    private $em;
    private $fileRepository;

    public function __construct(EntityManagerInterface $em, FileRepository $fileRepository)
    {
        $this->em = $em;
        $this->fileRepository = $fileRepository;
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
    public function findOrCreateFile(string $path, string $title): File
    {
        $file = $this->fileRepository->findOneByPath($path);
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
