<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\EvilChannel;
use App\Transfer\EvilChannelTransfer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class EvilChannelsController extends AbstractController
{
    protected EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    #[Route("/evil-channel", name: "evil_channel_add", methods: ["POST"])]
    public function add(
        EvilChannelTransfer $transfer,
        EntityManagerInterface $entityManager
    ): JsonResponse {
        $entity = new EvilChannel();
        $entity->setLink($transfer->getLink());
        $entity->setPlatform($transfer->getPlatform());
        $entity->setMeta($transfer->getMeta());
        $entity->setPostId($transfer->getPostId());
        $entity->setCreatedAt(new \DateTime($transfer->getCreatedAt()));

        /** @var \App\Repository\EvilChannelRepository $repo */
        $repo = $entityManager->getRepository(EvilChannel::class);
        $existed = $repo->findOneByLinkAndId($entity);

        if (!$existed instanceof EvilChannel) {
            $entityManager->persist($entity);
            $entityManager->flush();

            return new JsonResponse([
                'success' => true,
                'message' => 'new',
            ]);
        }

        return new JsonResponse([
            'success' => true,
            'message' => 'exist',
        ]);
    }

    #[Route("/evil-channel/{channel}/{id}", name: "check", methods: ["GET"])]
    public function hasPost(
        string $channel,
        string $id,
        EntityManagerInterface $entityManager
    ) {
        /** @var \App\Repository\EvilChannelRepository $repo */
        $repo = $entityManager->getRepository(EvilChannel::class);
        $existed = $repo->findOneBy([
            'postId' => $channel . '/' . $id,
        ]);

        if (!$existed instanceof EvilChannel) {
            return new JsonResponse([
                'success' => false,
                'message' => 'not exist',
            ]);
        }

        return new JsonResponse([
            'success' => true,
            'message' => 'exist',
        ]);
    }
}
