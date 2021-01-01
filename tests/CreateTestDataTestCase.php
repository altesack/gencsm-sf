<?php

namespace App\Tests;

use App\Tests\DataFixtures\AppFixtures;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\StringInput;

class CreateTestDataTestCase extends FixtureAwareTestCase
{
    /**
     * @var EntityManager
     */
    protected $entityManager;
    /**
     * @var Application
     */
    private static $application;
    protected static $client = null;

    protected function setUp(): void
    {
        self::$client = static::createClient();
        self::bootKernel();
        $this->entityManager = self::$kernel->getContainer()
            ->get('doctrine')
            ->getManager();
        self::runCommand('doctrine:schema:drop --force ');
        self::runCommand('doctrine:schema:create');
        $this->addFixture(new AppFixtures());
        $this->executeFixtures();

        parent::setUp();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->entityManager = null;
        self::$client = null;
    }

    protected static function runCommand($command)
    {
        $command = sprintf('%s --quiet --env=test', $command);

        return self::getApplication()->run(new StringInput($command));
    }

    protected static function getApplication()
    {
        if (null === self::$application) {
            self::getClient();

            self::$application = new Application(self::$client->getKernel());
            self::$application->setAutoExit(false);
        }

        return self::$application;
    }

    protected static function getClient(): void
    {
        if (!self::$client) {
            self::$client = static::createClient();
        }
    }
}
