<?php

namespace App\Command;

use App\Entity\Family;
use App\Entity\FamilyEvent;
use App\Entity\File;
use App\Entity\Person;
use App\Entity\PersonsEvent;
use App\Entity\Place;
use App\Factory\FamilyFactory;
use App\Factory\PersonFactory;
use PhpGedcom\Parser;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GencmsImportgedcomCommand extends Command
{
    protected $em;
    protected $personFactory;
    protected $familyFactory;

    public function __construct(PersonFactory $personFactory, FamilyFactory $familyFactory)
    {
        parent::__construct();
        $this->personFactory = $personFactory;
        $this->familyFactory = $familyFactory;
    }

    protected function configure()
    {
        $this
            ->setName('gencms:importgedcom')
            ->setDescription('Import data from GEDCOM file')
            ->addArgument('filename', InputArgument::REQUIRED, 'File name');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $startTime = time();
        $filename = $input->getArgument('filename');
        $filesize = filesize($filename);

        $parser = new Parser();
        $gedcom = $parser->parse($filename);

        $individuals = $gedcom->getIndi();
        $families = $gedcom->getFam();
        $bar = new ProgressBar($output, count($individuals) + count($families));

        foreach ($individuals as $individual) {
            $this->personFactory->createPersonFromIndi($individual);
            $bar->advance();
        }
        foreach ($families as $family) {
            $this->familyFactory->createFamilyFromFam($family);
            $bar->advance();
        }
        $bar->finish();

        $endTime = time();
        $takenSeconds = $endTime - $startTime;
        if ($takenSeconds > 0) {
            $rate = round($filesize / $takenSeconds, 2);
            $output->writeln("\n$takenSeconds seconds taken to handle $filesize bytes. $rate bytes per second\n");
        }

        return 0;
    }
}
