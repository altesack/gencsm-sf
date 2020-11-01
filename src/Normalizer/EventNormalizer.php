<?php

namespace App\Normalizer;

use App\Entity\AbstractEvent;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class EventNormalizer implements NormalizerInterface
{
    public function normalize($object, string $format = null, array $context = [])
    {
        if (is_null($object)) {
            return null;
        }

        return [
            'id'          => $object->getId(),
            'title'       => $object->getTitle(),
            'place'       => $object->getPlace()->getTitle(),
            'date'        => $object->getDate(),
            'description' => $object->getDescription(),
        ];
    }

    public function supportsNormalization($data, string $format = null)
    {
        return $data instanceof AbstractEvent;
    }
}
