<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Channel;
use App\Entity\EntityInterface;
use App\Entity\Miner;
use App\Entity\Post;
use App\Transfer\Request\MinerChannelConnectTransfer;
use App\Transfer\Request\MinerPostArchiveTransfer;
use App\Transfer\Request\MinerPostConnectTransfer;
use App\Transfer\Request\MinerTransfer;
use App\TransferEntityConverter\MinerConverter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

class MinerController extends AbstractController
{
    protected const IGNORED_ATTRIBUTES = [
        'posts',
        'miners',
        'minerQueue',
        'minerArchive',
        'postQueue',
        'postArchive',
        '__initializer__',
        '__cloner__',
        '__isInitialized__',
    ];

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

        return $this->json($miner);
    }

    #[Route("/miner/{title}", name: "miner_get", methods: ["GET"])]
    public function getMiner(string $title): JsonResponse
    {
        /** @var \App\Repository\MinerRepository $repo */
        $repo = $this->em->getRepository(Miner::class);
        $miner = $repo->findOneBy(['title' => $title]);

        return $this->json($miner, 200, [], [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function (EntityInterface $object, $format, $context) {
                return $object->getId();
            },
            AbstractNormalizer::IGNORED_ATTRIBUTES => static::IGNORED_ATTRIBUTES,
        ]);
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
            return $this->json([]);
        }

        $channel = $repoChannel->findOneBy(['title' => $transfer->getChannelTitle()]);
        if (!$channel instanceof Channel) {
            return $this->json([]);
        }

        $miner->addChannel($channel);

        $this->em->flush();

        return $this->json($miner, 200, [], [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function (EntityInterface $object, $format, $context) {
                return $object->getId();
            },
            AbstractNormalizer::IGNORED_ATTRIBUTES => static::IGNORED_ATTRIBUTES,
        ]);
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
            return $this->json([]);
        }

        $post = $repoPost->findOneBy([
            'channelTitle' => $transfer->getChannelTitle(),
            'postNumber' => $transfer->getPostNumber(),
        ]);
        if (!$post instanceof Post) {
            return $this->json([]);
        }

        $this->tmpFullPostChannel($post);

        if (!$miner->getChannels()->contains($post->getChannel())) {
            return $this->json([]);
        }

        $miner->addPostQueue($post);

        $this->em->flush();

        $list = [];
        foreach ($miner->getPostQueue() as $post) {
            $list[] = [
                'minerTitle' => $miner->getTitle(),
                'miner' => $miner->getId(),
                'post' => $post->getId(),
            ];
        }

        return $this->json($list);
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
            return $this->json([]);
        }

        $post = $repoPost->findOneBy([
            'channelTitle' => $transfer->getChannelTitle(),
            'postNumber' => $transfer->getPostNumber(),
        ]);
        if (!$post instanceof Post) {
            return $this->json([]);
        }

        $this->tmpFullPostChannel($post);
        if (!$miner->getChannels()->contains($post->getChannel())) {
            return $this->json([]);
        }

        if ($miner->getPostQueue()->contains($post)) {
            $miner->removePostQueue($post);

            if (!$miner->getPostArchive()->contains($post)) {
                $miner->addPostArchive($post);
            }

            $this->em->flush();
        }

        $list = [];
        foreach ($miner->getPostArchive() as $post) {
            $list[] = [
                'minerTitle' => $miner->getTitle(),
                'miner' => $miner->getId(),
                'post' => $post->getId(),
            ];
        }

        return $this->json($list);
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
