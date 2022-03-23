<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Post;
use App\Transfer\PostTransfer;
use App\TransferEntityConverter\PostConverter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    public function add(PostTransfer $transfer): JsonResponse
    {
        /** @var \App\Repository\PostRepository $repo */
        $repo = $this->em->getRepository(Post::class);
        $entity = $this->converter->convertTransfer($transfer);
        $repo->add($entity);

        return $this->json($entity);
    }

    #[Route("/post/first/{channel}", name: "post_get_first", methods: ["GET"])]
    public function getFirst(string $channel): JsonResponse
    {
        /** @var \App\Repository\PostRepository $repo */
        $repo = $this->em->getRepository(Post::class);
        $entity = $repo->getFirstPostInChannel($channel);

        return $this->json($entity);
    }

    #[Route("/post/last/{channel}", name: "post_get_last", methods: ["GET"])]
    public function getLast(string $channel): JsonResponse
    {
        /** @var \App\Repository\PostRepository $repo */
        $repo = $this->em->getRepository(Post::class);
        $entity = $repo->getLastPostInChannel($channel);

        return $this->json($entity);
    }
}
