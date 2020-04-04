<?php

namespace AppBundle\Normalizer;

use AppBundle\Entity\Person;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class PersonShortNormalizer implements NormalizerInterface
{
    public function normalize($object, $format = null, array $context = [])
    {
        if(is_null($object)){
            return null;
        }

        return [
            'id' => $object->getId(),
            'name' => $object->getGivn(),
            'surname' => $object->getSurn(),
            'sex' => $object->getSex(),
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
        return $data instanceof Person;
    }

}
