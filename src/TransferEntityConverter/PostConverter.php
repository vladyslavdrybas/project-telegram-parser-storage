<?php

declare(strict_types=1);

namespace App\TransferEntityConverter;

use App\Entity\Post;
use App\Transfer\PostTransfer;

class PostConverter extends AbstractConverter
{
    public function convertTransfer(PostTransfer $transfer): Post
    {
        $data = $this->normalizer->normalize($transfer, 'array');

        return $this->denormalizer->denormalize($data, Post::class);
    }
    
    public function convertEntity(Post $entity): PostTransfer
    {
        $data = $this->normalizer->normalize($entity, 'array');

        return $this->denormalizer->denormalize($data, PostTransfer::class);
    }
}
