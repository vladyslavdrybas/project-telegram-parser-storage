<?php

namespace App\Entity;

use App\Repository\ChannelRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ChannelRepository::class)
 * @ORM\Table(
 *      name="channel",
 * )
 */
class Channel extends AbstractEntity
{
    /**
     * @ORM\Column(name="title", type="text", length=255, unique=true)
     */
    protected string $title;
    /**
     * @ORM\Column(name="main_link", type="text")
     */
    protected string $mainLink;
    /**
     * @ORM\Column(name="message_link", type="text")
     */
    protected string $messageLink;
    /**
     * @ORM\Column(name="active", type="boolean", options={"default":true})
     */
    protected bool $active = true;

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getMainLink(): string
    {
        return $this->mainLink;
    }

    /**
     * @param string $mainLink
     */
    public function setMainLink(string $mainLink): void
    {
        $this->mainLink = $mainLink;
    }

    /**
     * @return string
     */
    public function getMessageLink(): string
    {
        return $this->messageLink;
    }

    /**
     * @param string $messageLink
     */
    public function setMessageLink(string $messageLink): void
    {
        $this->messageLink = $messageLink;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * @param bool $active
     */
    public function setActive(bool $active): void
    {
        $this->active = $active;
    }
}
