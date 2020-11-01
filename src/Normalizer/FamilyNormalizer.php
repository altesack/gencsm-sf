<?php

namespace App\Normalizer;

use App\Entity\Family;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class FamilyNormalizer implements NormalizerInterface
{
    public function normalize($object, string $format = null, array $context = [])
    {
        if (is_null($object)) {
            return null;
        }

        return [
            'id'       => $object->getId(),
            'husband'  => (new PersonShortNormalizer())->normalize($object->getHusband()),
            'wife'     => (new PersonShortNormalizer())->normalize($object->getWife()),
            'children' => (new PersonArrayShortNormalizer())->normalize($object->getChildren()),
            'files'    => (new FileArrayNormalizer())->normalize($object->getFiles()),
            'events'   => (new EventArrayNormalizer())->normalize($object->getEvents()),
        ];
    }

    public function supportsNormalization($data, string $format = null)
    {
        return $data instanceof Family;
    }
}
