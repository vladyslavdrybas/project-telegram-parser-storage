<?php

declare(strict_types=1);

namespace App\TransferEntityConverter;

use Symfony\Component\Serializer\Normalizer\DenormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;

abstract class AbstractConverter
{
    use NormalizerAwareTrait;
    use DenormalizerAwareTrait;
    protected SerializerInterface $serializer;

    public function __construct(
        NormalizerInterface $normalizer,
        DenormalizerInterface $denormalizer,
        SerializerInterface $serializer
    ) {
        $this->serializer = $serializer;
        $this->normalizer = $normalizer;
        $this->denormalizer = $denormalizer;
    }

    /**
     * @return \Symfony\Component\Serializer\SerializerInterface
     */
    protected function getSerializer(): SerializerInterface
    {
        return $this->serializer;
    }
}
