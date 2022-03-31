<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Channel;
use App\Entity\Miner;
use App\Entity\Post;
use App\Transfer\Request\MinerChannelConnectTransfer;
use App\Transfer\Request\MinerPostArchiveTransfer;
use App\Transfer\Request\MinerPostConnectTransfer;
use App\Transfer\Request\MinerTransfer;
use App\TransferEntityConverter\MinerConverter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use function array_diff;
use function dump;

class MinerController extends AbstractController
{
    protected EntityManagerInterface $em;
    protected MinerConverter $converter;

    public function __construct(
        EntityManagerInterface $em,
        MinerConverter $converter
    ) {
        $this->em = $em;
        $this->converter = $converter;
    }

    #[Route("/miner", name: "miner_add", methods: ["POST"])]
    public function addMiner(MinerTransfer $transfer): JsonResponse
    {
        /** @var \App\Repository\MinerRepository $repo */
        $repo = $this->em->getRepository(Miner::class);
        $miner = $this->converter->convertTransfer($transfer);
        $repo->add($miner);

        return $this->jsonEntity($miner);
    }

    #[Route("/miner/{title}", name: "miner_get", methods: ["GET"])]
    public function getMiner(string $title): JsonResponse
    {
        /** @var \App\Repository\MinerRepository $repo */
        $repo = $this->em->getRepository(Miner::class);
        $miner = $repo->findOneBy(['title' => $title]);

        return $this->jsonEntity($miner);
    }

    #[Route("/miner/channel/connect", name: "miner_channel_connect", methods: ["POST"])]
    public function connectMinerChannel(MinerChannelConnectTransfer $transfer): JsonResponse
    {
        /** @var \App\Repository\MinerRepository $repo */
        $repoMiner = $this->em->getRepository(Miner::class);
        /** @var \App\Repository\ChannelRepository $repo */
        $repoChannel = $this->em->getRepository(Channel::class);

        $miner = $repoMiner->findOneBy(['title' => $transfer->getMinerTitle()]);
        if (!$miner instanceof Miner) {
            return $this->jsonEntity(null);
        }

        $channel = $repoChannel->findOneBy(['title' => $transfer->getChannelTitle()]);
        if (!$channel instanceof Channel) {
            return $this->jsonEntity(null);
        }

        $miner->addChannel($channel);

        $this->em->flush();

        return $this->jsonEntity($miner);
    }

    #[Route("/miner/post/connect", name: "miner_post_connect", methods: ["POST"])]
    public function connectMinerPost(MinerPostConnectTransfer $transfer): JsonResponse
    {
        /** @var \App\Repository\MinerRepository $repo */
        $repoMiner = $this->em->getRepository(Miner::class);
        /** @var \App\Repository\PostRepository $repo */
        $repoPost = $this->em->getRepository(Post::class);

        $miner = $repoMiner->findOneBy(['title' => $transfer->getMinerTitle()]);
        if (!$miner instanceof Miner) {
            return $this->jsonEntity(null);
        }

        $post = $repoPost->findOneBy([
            'channelTitle' => $transfer->getChannelTitle(),
            'postNumber' => $transfer->getPostNumber(),
        ]);
        if (!$post instanceof Post) {
            return $this->jsonEntity(null);
        }

        $this->tmpFullPostChannel($post);

        if (!$miner->getChannels()->contains($post->getChannel())) {
            return $this->jsonEntity(null);
        }

        $miner->addPostQueue($post);

        $this->em->flush();

        return $this->jsonList([
            'minerTitle' => $miner->getTitle(),
            'miner' => $miner->getId(),
            'post' => $post->getId(),
        ]);
    }

    #[Route("/miner/post/archive", name: "miner_post_archive", methods: ["POST"])]
    public function archiveMinerPost(MinerPostArchiveTransfer $transfer): JsonResponse
    {
        /** @var \App\Repository\MinerRepository $repo */
        $repoMiner = $this->em->getRepository(Miner::class);
        /** @var \App\Repository\PostRepository $repo */
        $repoPost = $this->em->getRepository(Post::class);

        $miner = $repoMiner->findOneBy(['title' => $transfer->getMinerTitle()]);
        if (!$miner instanceof Miner) {
            return $this->jsonEntity(null);
        }

        $post = $repoPost->findOneBy([
            'channelTitle' => $transfer->getChannelTitle(),
            'postNumber' => $transfer->getPostNumber(),
        ]);
        if (!$post instanceof Post) {
            return $this->jsonEntity(null);
        }

        $this->tmpFullPostChannel($post);
        if (!$miner->getChannels()->contains($post->getChannel())) {
            return $this->jsonEntity(null);
        }

        if ($miner->getPostQueue()->contains($post)) {
            $miner->removePostQueue($post);

            if (!$miner->getPostArchive()->contains($post)) {
                $miner->addPostArchive($post);
            }

            $this->em->flush();
        }

        return $this->jsonList([
            'minerTitle' => $miner->getTitle(),
            'miner' => $miner->getId(),
            'post' => $post->getId(),
        ]);
    }

    #[Route("/miner/channel/posts/connect", name: "miner_channel_posts_connect", methods: ["GET"])]
    public function minerChannelPostConnections(): JsonResponse
    {
        /** @var \App\Repository\ChannelRepository $repo */
        $repo = $this->em->getRepository(Channel::class);
        $channels = $repo->findBy(['active' => true]);

        $miners = [];
        foreach ($channels as $channel) {
            $posts = $channel->getPosts()->toArray();
            foreach ($channel->getMiners() as $miner) {
                /** @var array|Post[] $postsQueue */
                $postsQueue = array_udiff(
                    $posts,
                    $miner->getPostArchive()->toArray(),
                    $miner->getPostQueue()->toArray(),
                    function (Post $a, Post $b) {
                        return strcmp(spl_object_hash($a), spl_object_hash($b));
                    }
                );

                foreach ($postsQueue as $post) {
                    $miners[] = [
                        'miner' => $miner->getId(),
                        'minerTitle' => $miner->getTitle(),
                        'channel' => $channel->getId(),
                        'channelTitle' => $channel->getTitle(),
                        'post' => $post->getId(),
                        'postNumber' => $post->getPostNumber(),
                    ];
                }
            }
        }

        return $this->jsonList($miners);
    }

    #[Route("/miner/queue/{minerTitle}", name: "miner_queue_get", methods: ["GET"])]
    public function minerMine(string $minerTitle): JsonResponse
    {
        /** @var \App\Repository\MinerRepository $repo */
        $repo = $this->em->getRepository(Miner::class);
        $miner = $repo->findOneBy(['title' => $minerTitle]);

        $queue = [];
        if ($miner instanceof Miner) {
            $queue = $miner->getPostQueue()->toArray();
        }

        return $this->jsonList([
            'miner' => $miner,
            'posts' => $queue,
        ]);
    }

    protected function tmpFullPostChannel(Post $post): void
    {
        if ($post->getChannel() instanceof Channel) {
            return;
        }

        /** @var \App\Repository\ChannelRepository $repo */
        $repoChannel = $this->em->getRepository(Channel::class);

        $channel = $repoChannel->findOneBy(['title' => $post->getChannelTitle()]);
        if (!$channel instanceof Channel) {
            return;
        }

        $post->setChannel($channel);
        $this->em->persist($post);
        $this->em->flush();
    }
}
