<?php

namespace App\Normalizer;

use App\Entity\Person;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class PersonShortNormalizer implements NormalizerInterface
{
    public function normalize($object, string $format = null, array $context = [])
    {
        if (is_null($object)) {
            return null;
        }

        return [
            'id'      => $object->getId(),
            'name'    => $object->getGivn(),
            'surname' => $object->getSurn(),
            'sex'     => $object->getSex(),
        ];
    }

    public function supportsNormalization($data, string $format = null)
    {
        return $data instanceof Person;
    }
}
