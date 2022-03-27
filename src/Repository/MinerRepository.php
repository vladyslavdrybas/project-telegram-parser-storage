<?php

namespace App\Repository;

use App\Entity\Miner;

/**
 * @method Miner|null find($id, $lockMode = null, $lockVersion = null)
 * @method Miner|null findOneBy(array $criteria, array $orderBy = null)
 * @method Miner[]    findAll()
 * @method Miner[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MinerRepository extends AbstractRepository
{
    public const MODEL = Miner::class;
}
