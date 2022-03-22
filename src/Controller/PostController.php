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
use function dump;


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
        $entity = $this->converter->convertTransfer($transfer);
        $this->em->getRepository(Post::class)->add($entity);

        return $this->json($entity);
    }
}
