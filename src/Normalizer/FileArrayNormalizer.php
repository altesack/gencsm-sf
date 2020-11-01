<?php

namespace App\Normalizer;

class FileArrayNormalizer extends AbstractArrayNormalizer
{
    public function __construct()
    {
        return parent::__construct(new FileNormalizer());
    }
}
