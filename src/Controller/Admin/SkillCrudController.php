<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\SluggerService;
use App\Entity\Skill;

class SkillCrudController extends AbstractCrudController
{
    private SluggerService $sluggerService;

    public function __construct(SluggerService $sluggerService)
    {
        $this->sluggerService = $sluggerService;
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
        if (!$entityInstance instanceof Skill){
            return;
        }
        $slug = $this->sluggerService->generateSlug($entityInstance->getName());
        $entityInstance->setSlug($slug);
        $entityManager->persist($entityInstance);
        $entityManager->flush();
    }
}
