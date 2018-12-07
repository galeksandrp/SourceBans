<?php

namespace SourceBans\Command;

use SourceBans\Entity\Ban;

class DeleteBan
{
    /** @var Ban */
    private $ban;

    public function __construct(Ban $ban)
    {
        $this->ban = $ban;
    }

    public function getBan(): Ban
    {
        return $this->ban;
    }
}