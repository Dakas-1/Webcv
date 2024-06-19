<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use App\Event\SkillEvent;
use App\Entity\Skill;

class SkillCrudController extends AbstractCrudController
{
    private EventDispatcherInterface $eventDispatcher;

    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    public static function getEntityFqcn(): string
    {
        return Skill::class;
    }
    public function configureFields(string $pageName): iterable
    {
        return [
            'name',
        ];
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if ($entityInstance instanceof Skill) {
            $event = new SkillEvent($entityInstance);
            $this->eventDispatcher->dispatch($event, SkillEvent::NAME);

            $entityManager->persist($entityInstance);
            $entityManager->flush();
        }
    }
    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if ($entityInstance instanceof Skill) {
            $event = new SkillEvent($entityInstance);
            $this->eventDispatcher->dispatch($event, SkillEvent::NAME);

            $entityManager->persist($entityInstance);
            $entityManager->flush();
        }
    }
}
