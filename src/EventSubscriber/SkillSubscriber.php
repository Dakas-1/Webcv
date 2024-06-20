<?php

namespace App\EventSubscriber;

use App\Event\SkillEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class SkillSubscriber implements EventSubscriberInterface
{
    private SluggerInterface $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            SkillEvent::NAME => 'onSkillCreatedOrUpdated',
        ];
    }

    public function onSkillCreatedOrUpdated(SkillEvent $event): void
    {
        $skill = $event->getSkill();

        if ($skill->getName() !== null) {
            $slug = $this->slugger->slug($skill->getName())->lower()->toString();
            $skill->setSlug($slug);
        }
    }
}
