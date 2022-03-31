<?php

namespace App\Entity;

use App\Repository\MinerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\MaxDepth;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=MinerRepository::class)
 * @ORM\Table(name="miner")
 */
class Miner extends AbstractEntity
{
    /**
     * @ORM\Column(name="title", type="text", length=255, unique=true)
     * @Groups({"show_miner", "list"})
     */
    protected string $title;

    /**
     * @ORM\ManyToMany(targetEntity="Post", inversedBy="minerQueue")
     * @ORM\JoinTable(
     *      name="miner_post_queue",
     *      joinColumns={
     *          @ORM\JoinColumn(name="miner_id", referencedColumnName="id")
     *      },
     *      inverseJoinColumns={
     *          @ORM\JoinColumn(name="post_id", referencedColumnName="id")
     *      }
     * )
     */
    protected Collection $postQueue;

    /**
     * @ORM\ManyToMany(targetEntity="Post", inversedBy="minerArchive")
     * @ORM\JoinTable(
     *      name="miner_post_archive",
     *      joinColumns={
     *          @ORM\JoinColumn(name="miner_id", referencedColumnName="id")
     *      },
     *      inverseJoinColumns={
     *          @ORM\JoinColumn(name="post_id", referencedColumnName="id")
     *      }
     * )
     */
    protected Collection $postArchive;

    /**
     * @MaxDepth(1)
     * @ORM\ManyToMany(targetEntity="Channel", inversedBy="miners")
     * @ORM\JoinTable(
     *      name="miner_channel",
     *      joinColumns={
     *          @ORM\JoinColumn(name="miner_id", referencedColumnName="id")
     *      },
     *      inverseJoinColumns={
     *          @ORM\JoinColumn(name="channel_id", referencedColumnName="id")
     *      }
     * )
     */
    protected Collection $channels;

    public function __construct()
    {
        parent::__construct();
        $this->postQueue = new ArrayCollection();
        $this->postArchive = new ArrayCollection();
        $this->channels = new ArrayCollection();
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
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPostQueue(): Collection
    {
        return $this->postQueue;
    }

    /**
     * @param \App\Entity\Post $post
     */
    public function addPostQueue(Post $post): void
    {
        if (!$this->postQueue->contains($post)) {
            $this->postQueue->add($post);
            $post->addMinerQueue($this);
        }
    }

    /**
     * @param \App\Entity\Post $post
     */
    public function removePostQueue(Post $post): void
    {
        if ($this->postQueue->contains($post)) {
            $this->postQueue->removeElement($post);
            $post->removeMinerQueue($this);
        }
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $postQueue
     */
    public function setPostQueue(Collection $postQueue): void
    {
        $this->postQueue = $postQueue;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPostArchive(): Collection
    {
        return $this->postArchive;
    }

    /**
     * @param \App\Entity\Post $post
     */
    public function addPostArchive(Post $post): void
    {
        if (!$this->postArchive->contains($post)) {
            $this->postArchive->add($post);
            $post->addMinerArchive($this);
        }
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $postArchive
     */
    public function setPostArchive(Collection $postArchive): void
    {
        $this->postArchive = $postArchive;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getChannels(): Collection
    {
        return $this->channels;
    }

    /**
     * @param \App\Entity\Channel $channel
     */
    public function addChannel(Channel $channel): void
    {
        if (!$this->channels->contains($channel)) {
            $this->channels->add($channel);
            $channel->addMiner($this);
        }
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $channels
     */
    public function setChannels(Collection $channels): void
    {
        $this->channels = $channels;
    }
}
