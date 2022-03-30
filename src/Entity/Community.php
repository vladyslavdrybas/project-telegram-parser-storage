<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\CommunityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommunityRepository::class)
 * @ORM\Table(name="community")
 */
class Community extends AbstractEntity
{
    /**
     * @ORM\Column(name="title", type="text", length=255, unique=true)
     */
    protected string $title;

    /**
     * @ORM\OneToMany(targetEntity="ChannelCommunitySupport", mappedBy="community")
     */
    protected Collection $channelCommunitySupports;

    public function __construct()
    {
        parent::__construct();
        $this->channelCommunitySupports = new ArrayCollection();
    }

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
     * @return \Doctrine\Common\Collections\ArrayCollection|\Doctrine\Common\Collections\Collection
     */
    public function getChannelCommunitySupports(): ArrayCollection|Collection
    {
        return $this->channelCommunitySupports;
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection|\Doctrine\Common\Collections\Collection $channelCommunitySupports
     */
    public function setChannelCommunitySupports(ArrayCollection|Collection $channelCommunitySupports): void
    {
        $this->channelCommunitySupports = $channelCommunitySupports;
    }
}
