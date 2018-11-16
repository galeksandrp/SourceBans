<?php

namespace SourceBans\Command;

use SourceBans\Entity\Game;

class UpdateGame
{
    /** @var Game */
    private $game;

    public function __construct(Game $game)
    {
        $this->game = $game;
    }

    public function getGame(): Game
    {
        return $this->game;
    }
}