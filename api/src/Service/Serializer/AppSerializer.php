<?php

namespace App\Service\Serializer;

use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class AppSerializer
{
    private Serializer $serializer;

    public function __construct(ObjectNormalizer $objectNormalizer)
    {
        $this->serializer = new Serializer([$objectNormalizer]);
    }

    /**
     * @param $data
     * @param $group
     * @return array|\ArrayObject|bool|float|int|string|null
     * @throws ExceptionInterface
     */
    public function normalize($data, $group)
    {
        if (is_array($data) && !empty($data)) {
            $result = [];
            foreach ($data as $item) {
                $result[] = $this->serializer->normalize($data, null, ['groups' => $group]);
            }
            return $result;
        }

        if ($data) {
            return $this->serializer->normalize($data, null, ['groups' => $group]);
        }

        return [];
    }
}