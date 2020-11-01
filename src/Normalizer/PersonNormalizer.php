<?php

namespace App\Normalizer;

use App\Entity\Person;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class PersonNormalizer implements NormalizerInterface
{
    public function normalize($object, string $format = null, array $context = [])
    {
        if (is_null($object)) {
            return null;
        }

        return [
            'id'                => $object->getId(),
            'name'              => $object->getGivn(),
            'surname'           => $object->getSurn(),
            'sex'               => $object->getSex(),
            'description'       => $object->getDescription(),
            'bornInFamily'      => (new FamilyShortNormalizer())->normalize($object->getBornInFamily()),
            'husbandInFamilies' => (new FamilyArrayShortNormalizer())->normalize($object->getHusbandInFamilies()),
            'wifeInFamilies'    => (new FamilyArrayShortNormalizer())->normalize($object->getWifeInFamilies()),
            'files'             => (new FileArrayNormalizer())->normalize($object->getFiles()),
            'events'            => (new EventArrayNormalizer())->normalize($object->getEvents()),
        ];
    }

    public function supportsNormalization($data, string $format = null)
    {
        return $data instanceof Person;
    }
}
