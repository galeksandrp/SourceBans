<?php

namespace SourceBans\Command;

use SourceBans\Entity\Group;

class DeleteGroup
{
    /** @var Group */
    private $group;

    public function __construct(Group $group)
    {
        $this->group = $group;
    }

    public function getGroup(): Group
    {
        return $this->group;
    }
}