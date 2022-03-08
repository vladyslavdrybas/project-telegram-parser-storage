<?php

namespace App\Repository;

use App\Entity\Celebrity;

/**
 * @method Celebrity|null find($id, $lockMode = null, $lockVersion = null)
 * @method Celebrity|null findOneBy(array $criteria, array $orderBy = null)
 * @method Celebrity[]    findAll()
 * @method Celebrity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CelebrityRepository extends AbstractRepository
{
    public const MODEL = Celebrity::class;
}
