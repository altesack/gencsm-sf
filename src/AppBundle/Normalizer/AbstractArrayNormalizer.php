<?php

namespace AppBundle\Normalizer;

use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class AbstractArrayNormalizer
{
    /**
     * @var $normalizer NormalizerInterface
     */
    private $normalizer;

    /**
     * Class constructor.
     * __construct
     *
     * @param  mixed $normalizer
     *
     * @return void
     */
    public function __construct(NormalizerInterface $normalizer)
    {
        $this->normalizer = $normalizer;

        return $this;
    }

    /**
     * Normalize array or Collection
     *
     * @param  mixed $data
     *
     * @return void
     */
    public function normalize($data)
    {
        $result = [];
        foreach ($data as $entry) {
            $normalizedEntry = $this->normalizer->normalize($entry);
            if ($normalizedEntry !== false) {
                $result[] = $normalizedEntry;
            }
        }

        return $result;
    }
}
