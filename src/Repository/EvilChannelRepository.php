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
}
