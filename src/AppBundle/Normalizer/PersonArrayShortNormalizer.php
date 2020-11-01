<?php

namespace AppBundle\Normalizer;

class PersonArrayShortNormalizer extends AbstractArrayNormalizer
{
    public function __construct()
    {
        return parent::__construct(new PersonShortNormalizer());
    }
}
