<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Channel;
use App\Transfer\Request\ChannelTransfer;
use App\TransferEntityConverter\ChannelConverter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ChannelController extends AbstractController
{
    protected EntityManagerInterface $em;
    protected ChannelConverter $converter;

    public function __construct(
        EntityManagerInterface $em,
        ChannelConverter $converter
    ) {
        $this->em = $em;
        $this->converter = $converter;
    }

    #[Route("/channel", name: "channel_add", methods: ["POST"])]
    public function add(ChannelTransfer $transfer): JsonResponse
    {
        /** @var \App\Repository\ChannelRepository $repo */
        $repo = $this->em->getRepository(Channel::class);
        $entity = $this->converter->convertTransfer($transfer);
        $repo->add($entity);

        return $this->jsonEntity($entity);
    }

    #[Route("/channel/find/{title}", name: "channel_get", methods: ["GET"])]
    public function get(string $title): JsonResponse
    {
        /** @var \App\Repository\ChannelRepository $repo */
        $repo = $this->em->getRepository(Channel::class);
        $entity = $repo->findOneBy(['title' => $title]);

        return $this->jsonEntity($entity);
    }

    #[Route("/channel/list", name: "channel_list", methods: ["GET"])]
    public function list(): JsonResponse
    {
        /** @var \App\Repository\ChannelRepository $repo */
        $repo = $this->em->getRepository(Channel::class);
        $entities = $repo->findBy(['active' => true]);

        return $this->jsonList($entities);
    }
}
