<?php
namespace AppBundle\Normalizer;

use AppBundle\Normalizer\AbstractArrayNormalizer;

class PersonArrayShortNormalizer extends AbstractArrayNormalizer
{
    public function __construct()
    {
        return parent::__construct(new PersonShortNormalizer());
    }
}
