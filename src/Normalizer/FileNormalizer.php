<?php

namespace App\Normalizer;

use App\Entity\File;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class FileNormalizer implements NormalizerInterface
{
    public function normalize($object, string $format = null, array $context = [])
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

    public function supportsNormalization($data, string $format = null)
    {
        return $data instanceof File;
    }
}
