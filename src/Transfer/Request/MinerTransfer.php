<?php

declare(strict_types=1);

namespace App\Transfer\Request;

use App\Transfer\TransferInterface;

class MinerTransfer implements TransferInterface, TransferRequestInterface
{
    protected string $title;

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
}
