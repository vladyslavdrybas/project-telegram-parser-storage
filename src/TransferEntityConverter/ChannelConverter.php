<?php

declare(strict_types=1);

namespace App\TransferEntityConverter;

use App\Entity\Channel;
use App\Transfer\ChannelTransfer;

class ChannelConverter extends AbstractConverter
{
    public function convertTransfer(ChannelTransfer $transfer): Channel
    {
        $data = $this->normalizer->normalize($transfer, 'array');

        return $this->denormalizer->denormalize($data, Channel::class);
    }

    public function convertEntity(Channel $entity): ChannelTransfer
    {
        $data = $this->normalizer->normalize($entity, 'array');

        return $this->denormalizer->denormalize($data, ChannelTransfer::class);
    }
}
