<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
     * @ORM\ManyToOne(targetEntity="Channel", inversedBy="posts")
     * @ORM\JoinColumn(name="channel_id", referencedColumnName="id", nullable=true)
     */
    protected ?Channel $channel = null;

    /**
     * @ORM\Column(name="channel", type="string", length=255)
     */
    protected string $channelTitle;

    /**
     * @ORM\Column(name="post_number", type="integer")
     */
    protected int $postNumber;

    /**
     * @ORM\Column(name="meta", type="text")
     */
    protected string $meta;

    /**
     * @ORM\ManyToMany(targetEntity="Miner", mappedBy="postQueue")
     */
    protected Collection $minerQueue;

    /**
     * @ORM\ManyToMany(targetEntity="Miner", mappedBy="postArchive")
     */
    protected Collection $minerArchive;

    public function __construct()
    {
        parent::__construct();
        $this->minerQueue = new ArrayCollection();
        $this->minerArchive = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getPostId(): string
    {
        return $this->getChannel()->getTitle() . '/' . $this->getPostNumber();
    }

    /**
     * @return \App\Entity\Channel|null
     */
    public function getChannel(): ?Channel
    {
        return $this->channel;
    }

    /**
     * @param \App\Entity\Channel|null $channel
     */
    public function setChannel(?Channel $channel): void
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

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMinerQueue(): Collection
    {
        return $this->minerQueue;
    }

    /**
     * @param \App\Entity\Miner $miner
     */
    public function addMinerQueue(Miner $miner): void
    {
        if (!$this->minerQueue->contains($miner)) {
            $this->minerQueue->add($miner);
        }
    }

    /**
     * @param \App\Entity\Miner $miner
     */
    public function removeMinerQueue(Miner $miner): void
    {
        if ($this->minerQueue->contains($miner)) {
            $this->minerQueue->removeElement($miner);
            $miner->removePostQueue($this);
        }
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $minerQueue
     */
    public function setMinerQueue(Collection $minerQueue): void
    {
        $this->minerQueue = $minerQueue;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMinerArchive(): Collection
    {
        return $this->minerArchive;
    }

    /**
     * @param \App\Entity\Miner $miner
     */
    public function addMinerArchive(Miner $miner): void
    {
        if (!$this->minerArchive->contains($miner)) {
            $this->minerArchive->add($miner);
        }
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $minerArchive
     */
    public function setMinerArchive(Collection $minerArchive): void
    {
        $this->minerArchive = $minerArchive;
    }

    /**
     * @return string
     */
    public function getChannelTitle(): string
    {
        return $this->channelTitle;
    }

    /**
     * @param string $channelTitle
     */
    public function setChannelTitle(string $channelTitle): void
    {
        $this->channelTitle = $channelTitle;
    }
}
