<?php
namespace AppBundle\Normalizer;

use AppBundle\Normalizer\AbstractArrayNormalizer;

class FamilyArrayShortNormalizer extends AbstractArrayNormalizer
{
    public function __construct()
    {
        return parent::__construct(new FamilyShortNormalizer());
    }
}
