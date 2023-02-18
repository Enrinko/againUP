<?php

namespace App\Controller;

use http\Env\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SiteController extends AbstractController {
    #[Route('/', name: "mainPage")]
    public function renderIndex(): Response {
        return $this->render('index.html.twig');
    }
}