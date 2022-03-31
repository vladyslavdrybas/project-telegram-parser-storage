<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\SourceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=SourceRepository::class)
 * @ORM\Table(name="source")
 */
class Source extends AbstractEntity
{
    /**
     * @ORM\Column(name="title", type="text", length=255, unique=true)
     * @Groups({"show_source", "list"})
     */
    protected string $title;

    /**
     * @ORM\OneToMany(targetEntity="Channel", mappedBy="source")
     */
    protected Collection $channels;

    public function __construct()
    {
        parent::__construct();
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
     * @return \Doctrine\Common\Collections\ArrayCollection|\Doctrine\Common\Collections\Collection
     */
    public function getChannels(): ArrayCollection|Collection
    {
        return $this->channels;
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection|\Doctrine\Common\Collections\Collection $channels
     */
    public function setChannels(ArrayCollection|Collection $channels): void
    {
        $this->channels = $channels;
    }
}
