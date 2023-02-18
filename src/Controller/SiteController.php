<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SiteController extends AbstractController
{
    #[Route('/', name: "mainPage")]
    public function index(): Response
    {
        return $this->render('index.html.twig', ['title' => 'Главная']);
    }

    #[Route('/lecture/list', name: "lectures_list", priority: 1)]
    public function lectures_list(): Response
    {
        return $this->render('lectures.html.twig');
    }

    #[Route('/lecture/{name}', name: "lecture")]
    public function showLecture(): Response
    {
        return $this->render('lecture.html.twig');
    }

    #[Route('/test/list', name: "tests_list", priority: 1)]
    public function tests_list(): Response
    {
        return $this->render('tests.html.twig');
    }

    #[Route('/test/{name}', name: "test")]
    public function showTest(): Response
    {
        return $this->render('test.html.twig');
    }

    #[Route('/about', name: "about")]
    public function about(): Response
    {
        return $this->render('about.html.twig');
    }

    #[Route('/chat', name: "chat")]
    public function chat(): Response
    {
        return $this->render('chat.html.twig');
    }

    #[Route('/userCab', name: "cab")]
    public function userCab(): Response
    {
        return $this->render('userCab.html.twig');
    }

    #[Route('/auth', name: "auth")]
    public function auth(): Response
    {
        return $this->render('auth.html.twig');
    }

    #[Route('/logout', name: "test")]
    public function logout(): int
    {
        return 0;
    }
}