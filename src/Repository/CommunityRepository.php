<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Community;

/**
 * @method Community|null find($id, $lockMode = null, $lockVersion = null)
 * @method Community|null findOneBy(array $criteria, array $orderBy = null)
 * @method Community[]    findAll()
 * @method Community[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommunityRepository extends AbstractRepository
{
    public const MODEL = Community::class;
}
