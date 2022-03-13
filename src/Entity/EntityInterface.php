<?php

declare(strict_types=1);

namespace App\Entity;

use Symfony\Component\Uid\UuidV4;

interface EntityInterface
{
    /**
     * @return string
     */
    public function getEntityClass(): string;

    /**
     * @return UuidV4|null
     */
    public function getId(): ?UuidV4;
}
