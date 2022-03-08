<?php

namespace App\Entity;

use App\Repository\EvilChannelsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EvilChannelsRepository::class)
 */
class EvilChannels extends AbstractEntity
{
    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $platform;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $link;

    /**
     * @ORM\Column(type="text")
     */
    private string $reason;

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
    public function getReason(): string
    {
        return $this->reason;
    }

    /**
     * @param string $reason
     */
    public function setReason(string $reason): void
    {
        $this->reason = $reason;
    }
}
