<?php

namespace AppBundle\Normalizer;

use AppBundle\Entity\Family;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class FamilyShortNormalizer implements NormalizerInterface
{
    public function normalize($object, $format = null, array $context = [])
    {
        if (is_null($object)) {
            return null;
        }

        return [
            'id'      => $object->getId(),
            'husband' => (new PersonShortNormalizer())->normalize($object->getHusband()),
            'wife'    => (new PersonShortNormalizer())->normalize($object->getWife()),
        ];
    }

    /**
     * supportsNormalization.
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
