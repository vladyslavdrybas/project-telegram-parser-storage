<?php

namespace App\Entity;

use App\Repository\EvilChannelRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=EvilChannelRepository::class)
 * @UniqueEntity(
 *     fields={"link", "postId"},
 *     errorPath="link",
 *     message="This link is already in use on that post."
 * )
 */
class EvilChannel extends AbstractEntity
{
    /**
     * @ORM\Column(type="string", length=255)
     */
    protected string $platform;

    /**
     * @ORM\Column(type="text")
     */
    protected string $link;

    /**
     * @ORM\Column(type="text")
     */
    protected string $postId;

    /**
     * @ORM\Column(type="text")
     */
    protected string $meta;

    /**
     * @return string
     */
    public function getPlatform(): string
    {
        return $this->platform;
    }

    /**
     * @param string $platform
     */
    public function setPlatform(string $platform): void
    {
        $this->platform = $platform;
    }

    /**
     * @return string
     */
    public function getLink(): string
    {
        return $this->link;
    }

    /**
     * @param string $link
     */
    public function setLink(string $link): void
    {
        $this->link = $link;
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

    /**
     * @return string
     */
    public function getPostId(): string
    {
        return $this->postId;
    }

    /**
     * @param string $postId
     */
    public function setPostId(string $postId): void
    {
        $this->postId = $postId;
    }
}
