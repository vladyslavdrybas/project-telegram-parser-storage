<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\EntityInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController as SymfonyAbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use function strtolower;

abstract class AbstractController extends SymfonyAbstractController
{
    protected const SERIALIZER_GROUP_BASE = 'base';
    protected const SERIALIZER_GROUP_SHOW = 'show';
    protected const SERIALIZER_GROUP_LIST = 'list';
    protected const SERIALIZER_GROUP_CREATED = 'created';
    protected const SERIALIZER_GROUP_UPDATED = 'updated';
    protected const SERIALIZER_GROUP_TIME = 'time';

    /**
     * @param \App\Entity\EntityInterface|null $entity
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    protected function jsonEntity(?EntityInterface $entity): JsonResponse
    {
        $typeSuffix = '';
        if ($entity instanceof EntityInterface) {
            $typeSuffix = '_' . strtolower($entity->getObject());
        }
        return $this->json($entity ?? [], 200, [], [
            AbstractNormalizer::GROUPS => [
                static::SERIALIZER_GROUP_SHOW . $typeSuffix,
                static::SERIALIZER_GROUP_BASE,
                static::SERIALIZER_GROUP_TIME,
            ],
        ]);
    }

    /**
     * @param array $list
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    protected function jsonList(array $list): JsonResponse
    {
        return $this->json($list, 200, [], [
            AbstractNormalizer::GROUPS => [
                static::SERIALIZER_GROUP_BASE,
                static::SERIALIZER_GROUP_TIME,
                static::SERIALIZER_GROUP_LIST,
            ],
        ]);
    }
}
