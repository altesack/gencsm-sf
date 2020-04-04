<?php
namespace AppBundle\Normalizer;

use AppBundle\Normalizer\AbstractArrayNormalizer;

class EventArrayNormalizer extends AbstractArrayNormalizer
{
    public function __construct()
    {
        return parent::__construct(new EventNormalizer());
    }
}
