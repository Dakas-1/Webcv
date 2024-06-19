<?php

namespace App\Event;

use App\Entity\Skill;
use Symfony\Contracts\EventDispatcher\Event;

class SkillEvent extends Event
{
    public const NAME = 'skill.created_or_updated';

    private Skill $skill;

    public function __construct(Skill $skill)
    {
        $this->skill = $skill;
    }

    public function getSkill(): Skill
    {
        return $this->skill;
    }
}
