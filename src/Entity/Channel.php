<?php

namespace App\Entity;

use App\Repository\ChannelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
     * @ORM\ManyToMany(targetEntity="Miner", mappedBy="channels")
     */
    protected Collection $miners;

    /**
     * @ORM\OneToMany(targetEntity="Post", mappedBy="channel")
     */
    protected Collection $posts;

    /**
     * @ORM\ManyToOne(targetEntity="Source", inversedBy="channels")
     * @ORM\JoinColumn(name="source_id", referencedColumnName="id", nullable=true)
     */
    protected Source $source;

    public function __construct()
    {
        parent::__construct();
        $this->miners = new ArrayCollection();
        $this->posts = new ArrayCollection();
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

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMiners(): Collection
    {
        return $this->miners;
    }

    /**
     * @param \App\Entity\Miner $miner
     */
    public function addMiner(Miner $miner): void
    {
        if (!$this->miners->contains($miner)) {
            $this->miners->add($miner);
            $miner->addChannel($this);
        }
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $miners
     */
    public function setMiners(Collection $miners): void
    {
        $this->miners = $miners;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection|\Doctrine\Common\Collections\Collection
     */
    public function getPosts(): ArrayCollection|Collection
    {
        return $this->posts;
    }

    /**
     * @param \App\Entity\Post $post
     */
    public function addPost(Post $post): void
    {
        if (!$this->posts->contains($post)) {
            $this->posts->add($post);
        }
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection|\Doctrine\Common\Collections\Collection $posts
     */
    public function setPosts(ArrayCollection|Collection $posts): void
    {
        $this->posts = $posts;
    }

    /**
     * @return \App\Entity\Source
     */
    public function getSource(): Source
    {
        return $this->source;
    }

    /**
     * @param \App\Entity\Source $source
     */
    public function setSource(Source $source): void
    {
        $this->source = $source;
    }
}
