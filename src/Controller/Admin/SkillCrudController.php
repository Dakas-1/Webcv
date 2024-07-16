<?php

namespace App\Controller\Admin;

use App\EasyAdmin\Field\TranslationsSimpleField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Skill;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class SkillCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Skill::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield TranslationsSimpleField::new('translations', null, [
            'name' => [
                'field_type' => TextType::class,
                'required' => true,
            ],
        ]);
        yield Field::new('slug', 'Slug')
            ->setFormType(TextType::class)
            ->setRequired(true)
            ->hideOnIndex();
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if ($entityInstance instanceof Skill) {
            $entityManager->persist($entityInstance);
            $entityManager->flush();
        }
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if ($entityInstance instanceof Skill) {
            $entityManager->persist($entityInstance);
            $entityManager->flush();
        }
    }
}
