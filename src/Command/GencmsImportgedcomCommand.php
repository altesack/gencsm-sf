<?php

namespace App\Command;

use App\Entity\Family;
use App\Entity\FamilyEvent;
use App\Entity\File;
use App\Entity\Person;
use App\Entity\PersonsEvent;
use App\Entity\Place;
use PhpGedcom\Parser;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GencmsImportgedcomCommand extends ContainerAwareCommand
{
    protected $em;
    protected $personsId = [];

    protected function configure()
    {
        $this
            ->setName('gencms:importgedcom')
            ->setDescription('Import data from GEDCOM file')
            ->addArgument('filename', InputArgument::REQUIRED, 'File name');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->em = $this->getContainer()->get('doctrine')->getEntityManager();

        $startTime = time();
        $filename = $input->getArgument('filename');
        $filesize = filesize($filename);

        $parser = new Parser();
        $gedcom = $parser->parse($filename);

        $individuals = $gedcom->getIndi();
        $families = $gedcom->getFam();
        $bar = new ProgressBar($output, count($individuals) + count($families));

        foreach ($individuals as $individual) {
            $this->importPerson($individual);
            $bar->advance();
        }
        foreach ($families as $family) {
            $this->importFamily($family);
            $bar->advance();
        }
        $bar->finish();

        $endTime = time();
        $takenSeconds = $endTime - $startTime;
        if ($takenSeconds > 0) {
            $rate = round($filesize / $takenSeconds, 2);
            $output->writeln("\n$takenSeconds seconds taken to handle $filesize bytes. $rate bytes per second\n");
        }
    }

    protected function importPerson($individual)
    {
        $gedcomId = $individual->getId();
        $surn = current($individual->getName())->getSurn();
        $givn = current($individual->getName())->getGivn();
        $name = current($individual->getName())->getName();
        $sex = $individual->getSex();
        $attr = $individual->getAllAttr();
        $events = $individual->getAllEven();
        $media = $individual->getObje();

        if ($givn == '') {
            $givn = $name;
        }
        $person = $this->createPerson($givn, $surn, $sex);
        $this->personsId[$gedcomId] = $person->getId();
        if ($events) {
            foreach ($events as $event) {
                $date = $event->getDate();
                $place = $this->findOrCreatePlace($event->getPlac());
                $this->createPersonsEvent($person, $event->getType(), $date, $place);
            }
        }

        if ($attr) {
            foreach ($attr as $event) {
                $date = $event->getDate();
                $place = $this->findOrCreatePlace($event->getPlac());
                $note = '';
                if (count($event->getNote()) > 0) {
                    $note = current($event->getNote())->getNote();
                }
                $this->createPersonsEvent($person, $event->getType(), $date, $note);
            }
        }

        foreach ($media as $mediafile) {
            $this->addFileToPerson($person, $mediafile->getTitl(), $mediafile->getFile());
        }
    }

    /**
     * createPerson.
     *
     * @param string $givn
     * @param string $surn
     * @param string $sex
     *
     * @return Person
     */
    protected function createPerson(string $givn = null, string $surn = null, string $sex = null)
    {
        $person = (new Person())
            ->setGivn($givn)
            ->setSurn($surn)
            ->setSex($sex);
        $this->em->persist($person);
        $this->em->flush();

        return $person;
    }

    protected function createFamily(Person $husband = null, Person $wife = null)
    {
        $family = (new Family())
            ->setHusband($husband)
            ->setWife($wife);
        $this->em->persist($family);
        $this->em->flush();

        return $family;
    }

    protected function createPersonsEvent(Person $person, string $type, string $date = null, Place $place = null, string $description = '')
    {
        $event = (new PersonsEvent())
            ->setPerson($person)
            ->setTitle($type)
            ->setDescription($description);

        if ($date) {
            $event->setDate($date);
        }
        if ($place) {
            $event->setPlace($place);
        }
        $this->em->persist($event);
        $this->em->flush();

        return $event;
    }

    protected function createFamilyEvent(family $family, string $type, string $date = null, Place $place = null, string $description = '')
    {
        $event = (new FamilyEvent())
            ->setFamily($family)
            ->setTitle($type)
            ->setDescription($description);

        if ($date) {
            $event->setDate($date);
        }
        if ($place) {
            $event->setPlace($place);
        }
        $this->em->persist($event);
        $this->em->flush();

        return $event;
    }

    protected function addFileToPerson(Person $person, string $path, string $title)
    {
        $file = $this->findOrCreateFile($path, $title);
        $file->addPerson($person);

        $this->em->flush();
    }

    protected function addFileToFamily(Family $family, string $path, string $title)
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

    /**
     * findOrCreatePlace.
     *
     * @param string $title
     *
     * @return Place|null
     */
    protected function findOrCreatePlace(string $title = null)
    {
        if ($title) {
            $place = $this->em->getRepository(Place::class)->findOneByTitle($title);
            if (!$place) {
                $place = (new Place())->setTitle($title);
                $this->em->persist($place);
                $this->em->flush();
            }

            return $place;
        }

        return null;
    }

    protected function importFamily($family)
    {
        $husb = $family->getHusb();
        $wife = $family->getWife();
        $children = $family->getChil();
        $events = $family->getAllEven();
        $media = $family->getObje();

        $husband = $this->findPerson($husb);
        $wife = $this->findPerson($wife);

        $family = $this->createFamily($husband, $wife);

        if ($children) {
            foreach ($children as $child) {
                if (isset($this->personsId[$child])) {
                    $person = $this->findPerson($child);
                    $person->setBornInFamily($family);
                    $this->em->flush();
                }
            }
        }

        if ($events) {
            foreach ($events as $event) {
                $date = $event->getDate();
                $place = $this->findOrCreatePlace($event->getPlac());
                $this->createFamilyEvent($family, $event->getType(), $date, $place);
            }
        }

        if ($media) {
            foreach ($media as $mediafile) {
                $this->addFileToFamily($family, $mediafile->getTitl(), $mediafile->getFile());
            }
        }
    }

    /**
     * findPerson.
     *
     * @param string $oldId
     *
     * @return Person|null
     */
    protected function findPerson(string $oldId = null)
    {
        return $this->em->getRepository(Person::class)
            ->findOneById($this->personsId[$oldId] ?? 0);
    }
}
