<?php

namespace AppBundle\Normalizer;

use AppBundle\Entity\Person;
use AppBundle\Normalizer\FamilyShortNormalizer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class PersonNormalizer implements NormalizerInterface
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
            'description' => $object->getDescription(),
            'bornInFamily' => (new FamilyShortNormalizer())->normalize($object->getBornInFamily()),
            'husbandInFamilies' => (new FamilyArrayShortNormalizer())->normalize($object->getHusbandInFamilies()),
            'wifeInFamilies' => (new FamilyArrayShortNormalizer())->normalize($object->getWifeInFamilies()),
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
        return $data instanceof Person;
    }

}
