<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\ChannelCommunitySupport;

/**
 * @method ChannelCommunitySupport|null find($id, $lockMode = null, $lockVersion = null)
 * @method ChannelCommunitySupport|null findOneBy(array $criteria, array $orderBy = null)
 * @method ChannelCommunitySupport[]    findAll()
 * @method ChannelCommunitySupport[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChannelCommunitySupportRepository extends AbstractRepository
{
    public const MODEL = ChannelCommunitySupport::class;
}
