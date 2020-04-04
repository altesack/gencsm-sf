<?php

namespace AppBundle\Normalizer;

use AppBundle\Entity\Family;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class FamilyNormalizer implements NormalizerInterface
{
    public function normalize($object, $format = null, array $context = [])
    {
        if(is_null($object)){
            return null;
        }

        return [
            'id' => $object->getId(),
            'husband' => (new PersonShortNormalizer())->normalize($object->getHusband()),
            'wife' => (new PersonShortNormalizer())->normalize($object->getWife()),
            'children' => (new PersonArrayShortNormalizer())->normalize($object->getChildren()),
            'files' => (new FileArrayNormalizer())->normalize($object->getFiles()),
            'events' => (new EventArrayNormalizer())->normalize($object->getEvents()),
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
        return $data instanceof Family;
    }

}
