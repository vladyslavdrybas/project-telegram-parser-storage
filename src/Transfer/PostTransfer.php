<?php

declare(strict_types=1);

namespace App\Transfer;

class PostTransfer implements TransferInterface
{
    protected string $channel;
    protected int $postNumber;
    protected string $meta;

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
