<?php

namespace App\Controller\Admin;

use App\EasyAdmin\Field\TranslationsSimpleField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Article;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
class ArticleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Article::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield TranslationsSimpleField::new('translations', null, [
            'title' => [
                'field_type' => TextType::class,
                'required' => true,
            ],
            'text' => [
                'field_type' => TextareaType::class,
                'required' => false,
            ],
        ]);
        yield Field::new('slug', 'Slug')
            ->setFormType(TextType::class)
            ->setRequired(true)
            ->hideOnIndex();
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if ($entityInstance instanceof Article) {
            $entityManager->persist($entityInstance);
            $entityManager->flush();
        }
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if ($entityInstance instanceof Article) {
            $entityManager->persist($entityInstance);
            $entityManager->flush();
        }
    }
}