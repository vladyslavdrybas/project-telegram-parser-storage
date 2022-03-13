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

    #[Route("/evil-channel", name: "contact_add", methods: ["POST"])]
    public function add(
        EvilChannelTransfer $transfer,
        EntityManagerInterface $entityManager
    ): JsonResponse {
        $entity = new EvilChannel();
        $entity->setLink($transfer->getLink());
        $entity->setPlatform($transfer->getPlatform());
        $entity->setReason($transfer->getReason());

        $entityManager->persist($entity);
        $entityManager->flush();

        return new JsonResponse([
            'success' => true,
        ]);
    }
}
