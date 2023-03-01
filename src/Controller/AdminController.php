<?php

namespace App\Controller;

use App\Entity\Lectures;
use App\Form\LectureFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;

class AdminController extends AbstractController
{
    #[Route('/admin', name:'admin')]
    public function admin(): Response
    {

    }

    public function createBreadcrumb($array, $breadcrumbs)
    {
        foreach ($array as $name => $link) {
            $breadcrumbs->addItem($name, $link);
        }
    }

    #[Route('/lecture/create', name:'addLecture')]
    public function createLecture(Breadcrumbs $breadcrumbs): Response
    {
        $user = new Lectures();
        $form = $this->createForm(LectureFormType::class, $user);
        $links = ['Главная' => "/", 'Лекции' => "/lecture/list", 'Создать лекцию' => ""];
        $this->createBreadcrumb($links, $breadcrumbs);
        $array = [
            'form' => $form,
            'this' => 'Создать лекцию',
        ];
        return $this->render('add-edit-lecture.html.twig', $array);
    }

    #[Route('/test/create', name:'addTest')]
    public function createTest(Breadcrumbs $breadcrumbs): Response
    {
        $links = ['Главная' => "/", 'Тесты' => "/test/list", 'Создать тест' => ""];
        $this->createBreadcrumb($links, $breadcrumbs);
        $array = [
            'this' => 'Создать тест',
        ];
        return $this->render('add-edit-test.html.twig', $array);
    }
    #[Route('/lecture/edit/{id}', name:'editLecture')]
    public function editLecture(int $id): Response
    {

    }

    #[Route('/test/edit/{id}', name:'editTest')]
    public function editTest(int $id): Response
    {

    }
}