<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Channel;
use App\Entity\Post;
use App\Transfer\Request\PostTransfer;
use App\TransferEntityConverter\PostConverter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;


class PostController extends AbstractController
{
    protected EntityManagerInterface $em;
    protected PostConverter $converter;

    public function __construct(
        EntityManagerInterface $em,
        PostConverter $converter
    ) {
        $this->em = $em;
        $this->converter = $converter;
    }

    #[Route("/post", name: "post_add", methods: ["POST"])]
    public function addPost(PostTransfer $transfer): JsonResponse
    {
        /** @var \App\Repository\PostRepository $repo */
        $repoPost = $this->em->getRepository(Post::class);
        $post = $this->converter->convertTransfer($transfer);

        /** @var \App\Repository\ChannelRepository $repo */
        $repoChannel = $this->em->getRepository(Channel::class);

        $channel = $repoChannel->findOneBy(['title' => $transfer->getChannelTitle()]);
        if (!$channel instanceof Channel) {
            return $this->jsonEntity(null);
        }

        $post->setChannel($channel);
        $repoPost->add($post);

        return $this->jsonEntity($post);
    }

    #[Route("/post/first/{channelTitle}", name: "post_get_first", methods: ["GET"])]
    public function getFirst(string $channelTitle): JsonResponse
    {
        /** @var \App\Repository\PostRepository $repo */
        $repo = $this->em->getRepository(Post::class);
        $post = $repo->getFirstPostInChannel($channelTitle);

        $this->tmpFullPostChannel($post);

        return $this->jsonEntity($post);
    }

    #[Route("/post/last/{channelTitle}", name: "post_get_last", methods: ["GET"])]
    public function getLast(string $channelTitle): JsonResponse
    {
        /** @var \App\Repository\PostRepository $repo */
        $repo = $this->em->getRepository(Post::class);
        $post = $repo->getLastPostInChannel($channelTitle);

        $this->tmpFullPostChannel($post);

        return $this->jsonEntity($post);
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
