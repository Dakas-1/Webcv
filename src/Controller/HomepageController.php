<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
class HomepageController extends AbstractController
{
    #[Route('/index')]
public function index(): Response
{
return $this->render('index-teacher.html.twig');
}
}