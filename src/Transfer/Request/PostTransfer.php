<?php

declare(strict_types=1);

namespace App\Transfer\Request;

use App\Transfer\TransferInterface;

class PostTransfer implements TransferInterface, TransferRequestInterface
{
    protected string $channelTitle;
    protected int $postNumber;
    protected string $meta;

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
