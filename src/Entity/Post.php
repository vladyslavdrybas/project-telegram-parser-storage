<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=PostRepository::class)
 * @ORM\Table(
 *      name="post",
 *      uniqueConstraints={@ORM\UniqueConstraint(columns={"channel", "post_number"})}
 * )
 * @UniqueEntity(
 *     fields={"channel", "postNumber"},
 *     errorPath="postNumber",
 *     message="This postNumber is already in use on that channel."
 * )
 */
class Post extends AbstractEntity
{
    /**
     * @ORM\Column(name="channel", type="text", length=255)
     */
    protected string $channel;
    /**
     * @ORM\Column(name="post_number", type="integer")
     */
    protected int $postNumber;
    /**
     * @ORM\Column(name="meta", type="text")
     */
    protected string $meta;

    /**
     * @return string
     */
    public function getPostId(): string
    {
        return $this->getChannel() . '/' . $this->getPostNumber();
    }

    /**
     * @return string
     */
    public function getChannel(): string
    {
        return $this->channel;
    }

    /**
     * @param string $channel
     */
    public function setChannel(string $channel): void
    {
        $this->channel = $channel;
    }

    /**
     * @return int
     */
    public function getPostNumber(): int
    {
        return $this->postNumber;
    }

    /**
     * @param int $postNumber
     */
    public function setPostNumber(int $postNumber): void
    {
        $this->postNumber = $postNumber;
    }

    /**
     * @return string
     */
    public function getMeta(): string
    {
        return $this->meta;
    }

    /**
     * @param string $meta
     */
    public function setMeta(string $meta): void
    {
        $this->meta = $meta;
    }
}
