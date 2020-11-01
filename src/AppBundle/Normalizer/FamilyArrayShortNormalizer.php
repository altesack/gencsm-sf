<?php

namespace AppBundle\Normalizer;

class FamilyArrayShortNormalizer extends AbstractArrayNormalizer
{
    public function __construct()
    {
        return parent::__construct(new FamilyShortNormalizer());
    }
}
