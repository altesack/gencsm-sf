<?php

namespace AppBundle\Normalizer;

class FileArrayNormalizer extends AbstractArrayNormalizer
{
    public function __construct()
    {
        return parent::__construct(new FileNormalizer());
    }
}
