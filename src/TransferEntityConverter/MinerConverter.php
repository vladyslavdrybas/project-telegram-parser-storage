<?php

declare(strict_types=1);

namespace App\TransferEntityConverter;

use App\Entity\Miner;
use App\Transfer\Request\MinerTransfer;

class MinerConverter extends AbstractConverter
{
    public function convertTransfer(MinerTransfer $transfer): Miner
    {
        $data = $this->normalizer->normalize($transfer, 'array');

        return $this->denormalizer->denormalize($data, Miner::class);
    }

    public function convertEntity(Miner $entity): MinerTransfer
    {
        $data = $this->normalizer->normalize($entity, 'array');

        return $this->denormalizer->denormalize($data, MinerTransfer::class);
    }
}
