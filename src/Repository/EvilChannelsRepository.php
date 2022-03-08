<?php

namespace App\Repository;

use App\Entity\EvilChannels;

/**
 * @method EvilChannels|null find($id, $lockMode = null, $lockVersion = null)
 * @method EvilChannels|null findOneBy(array $criteria, array $orderBy = null)
 * @method EvilChannels[]    findAll()
 * @method EvilChannels[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EvilChannelsRepository extends AbstractRepository
{
    public const MODEL = EvilChannels::class;
}
