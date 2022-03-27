<?php

declare(strict_types=1);

namespace App\Transfer\Request;

use App\Transfer\TransferInterface;

class MinerPostConnectTransfer implements TransferInterface, TransferRequestInterface
{
    protected string $minerTitle;
    protected string $channelTitle;
    protected string $postNumber;

    /**
     * @return string
     */
    public function getMinerTitle(): string
    {
        return $this->minerTitle;
    }

    /**
     * @param string $minerTitle
     */
    public function setMinerTitle(string $minerTitle): void
    {
        $this->minerTitle = $minerTitle;
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

    /**
     * @return string
     */
    public function getPostNumber(): string
    {
        return $this->postNumber;
    }

    /**
     * @param string $postNumber
     */
    public function setPostNumber(string $postNumber): void
    {
        $this->postNumber = $postNumber;
    }
}
