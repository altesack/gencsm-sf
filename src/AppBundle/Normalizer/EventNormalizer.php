<?php

namespace AppBundle\Normalizer;

use AppBundle\Entity\AbstractEvent;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class EventNormalizer implements NormalizerInterface
{
    public function normalize($object, $format = null, array $context = [])
    {
        if(is_null($object)){
            return null;
        }

        return [
            'id' => $object->getId(),
            'title' => $object->getTitle(),
            'place' => $object->getPlace()->getTitle(),
            'date' => $object->getDate(),
            'description' => $object->getDescription(),
        ];
    }

    /**
     * supportsNormalization
     *
     * @param mixed  $data   Data to normalize
     * @param string $format The format being (de-)serialized from or into
     *
     * @return bool
     */    
    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof AbstractEvent;
    }

}
