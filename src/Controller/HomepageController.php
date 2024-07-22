<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Skill;

class HomepageController extends AbstractController
{
    #[Route('/', name: 'app_homepage')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $skills = $entityManager->getRepository(Skill::class)->findAll();

        if (!$skills) {
            throw $this->createNotFoundException('The skill does not exist');
        }

        return $this->render('index-teacher.html.twig', [
            'skills' => $skills,
        ]);
    }
}
