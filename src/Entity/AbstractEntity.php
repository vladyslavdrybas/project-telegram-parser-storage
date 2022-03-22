<?php

declare(strict_types=1);

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Uid\UuidV4;
use function array_pop;
use function explode;

class AbstractEntity implements EntityInterface
{
    use TimestampableEntity;

    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="App\Generator\UuidGenerator")
     */
    protected ?UuidV4 $id;

    public function __construct()
    {
        $this->createdAt = new DateTime();
        $this->updatedAt = new DateTime();
    }

    /**
     * @return UuidV4|null
     */
    public function getId(): ?UuidV4
    {
        return $this->id;
    }

    /**
     * @param UuidV4 $id
     */
    public function setId(UuidV4 $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        $namespace = explode('\\', static::class);

        return array_pop($namespace);
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->getId()->toRfc4122();
    }
}
