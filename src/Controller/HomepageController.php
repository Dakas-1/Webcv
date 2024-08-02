<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Skill;
use App\Entity\Article;

class HomepageController extends AbstractController
{
    #[Route('/{_locale}', name: 'app_homepage')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $skills = $entityManager->getRepository(Skill::class)->findAll();
        $articles = $entityManager->getRepository(Article::class)->findAll();

        if (!$skills) {
            throw $this->createNotFoundException('The skill does not exist');
        }
        if (!$articles) {
            throw $this->createNotFoundException('The article does not exist');
        }

        return $this->render('index-teacher.html.twig', [
            'skills' => $skills,
            'articles' => $articles,
        ]);
    }
}
