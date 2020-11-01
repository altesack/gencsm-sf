<?php

namespace AppBundle\Normalizer;

use AppBundle\Entity\File;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class FileNormalizer implements NormalizerInterface
{
    public function normalize($object, $format = null, array $context = [])
    {
        if (is_null($object)) {
            return null;
        }

        return [
            'id'       => $object->getId(),
            'title'    => $object->getTitle(),
            'path'     => $object->getPath(),
            'persons'  => (new PersonArrayShortNormalizer())->normalize($object->getPersons()),
            'families' => (new FamilyArrayShortNormalizer())->normalize($object->getFamilies()),
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
        return $data instanceof File;
    }
}
