<?php

namespace App\Tests\Factory;

use App\Factory\PlaceFactory;
use App\Tests\CreateTestDataTestCase;


class PlaceFactoryTest extends CreateTestDataTestCase
{
    public function testCreatePlace()
    {
        /** @var PlaceFactory $placeFactory */
        $placeFactory = self::$kernel->getContainer()->get('App\Factory\PlaceFactory');
        $place = $placeFactory->createPlace('Wechmar');

        $this->assertEquals('Wechmar', $place->getTitle());
        $this->assertEquals(1, $place->getId());
    }

    public function testFindOrCreatePlace()
    {
        /** @var PlaceFactory $placeFactory */
        $placeFactory = self::$kernel->getContainer()->get('App\Factory\PlaceFactory');
        $place = $placeFactory->findOrCreatePlace(null);
        $this->assertNull($place);

        // New place with the new ID should be created
        $place = $placeFactory->findOrCreatePlace('Leipzig');
        $this->assertEquals('Leipzig', $place->getTitle());
        $this->assertEquals(1, $place->getId());

        // When we do it again we should get the place we created before with same ID
        $place = $placeFactory->findOrCreatePlace('Leipzig');
        $this->assertEquals('Leipzig', $place->getTitle());
        $this->assertEquals(1, $place->getId());
    }
}
