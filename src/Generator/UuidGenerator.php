<?php

declare(strict_types=1);

namespace App\Generator;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Id\AbstractIdGenerator;
use Symfony\Component\Uid\UuidV4;

class UuidGenerator extends AbstractIdGenerator
{
    /**
     * Generate an identifier
     *
     * @param \Doctrine\ORM\EntityManager  $em
     * @param \Doctrine\ORM\Mapping\Entity $entity
     *
     * @return string
     * @throws \Exception
     */
    public function generate(EntityManager $em, $entity)
    {
        $uuid = new UuidV4();

        return $uuid->toRfc4122();
    }
}
