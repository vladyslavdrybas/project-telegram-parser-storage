<?php

namespace App\Repository;

use App\Entity\Post;

/**
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends AbstractRepository
{
    public const MODEL = Post::class;

    /**
     * @param string $channelTitle
     * @return \App\Entity\Post|null
     */
    public function getFirstPostInChannel(string $channelTitle): ?Post
    {
        return $this->createQueryBuilder('t')
            ->where('t.channelTitle = :val')
            ->setParameter('val', $channelTitle)
            ->orderBy('t.postNumber', 'ASC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    /**
     * @param string $channel
     * @return \App\Entity\Post|null
     */
    public function getLastPostInChannel(string $channel): ?Post
    {
        return $this->createQueryBuilder('t')
            ->where('t.channelTitle = :val')
            ->setParameter('val', $channel)
            ->orderBy('t.postNumber', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
