<?php

namespace AppBundle\Normalizer;

class EventArrayNormalizer extends AbstractArrayNormalizer
{
    public function __construct()
    {
        return parent::__construct(new EventNormalizer());
    }
}
