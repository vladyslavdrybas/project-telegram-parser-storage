<?php

namespace App\Repository;

use App\Entity\EvilChannel;

/**
 * @method EvilChannel|null find($id, $lockMode = null, $lockVersion = null)
 * @method EvilChannel|null findOneBy(array $criteria, array $orderBy = null)
 * @method EvilChannel[]    findAll()
 * @method EvilChannel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EvilChannelRepository extends AbstractRepository
{
    public const MODEL = EvilChannel::class;

    /**
     * @param EvilChannel $entity
     * @return \App\Entity\EvilChannel|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findOneByLink(EvilChannel $entity): ?EvilChannel
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.link = :val')
            ->setParameter('val', $entity->getLink())
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }
}
