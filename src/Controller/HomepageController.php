<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Skill;

class HomepageController extends AbstractController
{
    #[Route('/{_locale}', name: 'app_homepage', requirements: ['_locale' => 'en|ru|'])]
    public function index(EntityManagerInterface $entityManager, Request $request, UrlGeneratorInterface $urlGenerator): Response
    {
        $skills = $entityManager->getRepository(Skill::class)->findAll();

        if (!$skills) {
            throw $this->createNotFoundException('The skill does not exist');
        }

        if ($request->getLocale() === 'en') {
            $newLocale = 'ru';
        }elseif($request->getLocale() === 'ru'){
            $newLocale = 'en';
        }else{
            $newLocale = null;
        }

        if ($newLocale !== null) {
            $url = $urlGenerator->generate('app_homepage', ['_locale' => $newLocale]);
        } else {
            $url = $urlGenerator->generate('app_homepage');
        }

        $fullUrl = $request->getSchemeAndHttpHost() . $url;

        return $this->render('index-teacher.html.twig', [
            'skills' => $skills,
            'fullUrl' => $fullUrl,
        ]);
    }
}
