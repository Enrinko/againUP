<?php

namespace App\Controller;

use App\Entity\Lectures;
use App\Form\LectureFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    public function createLecture(EntityManagerInterface $manager, Request $request, Breadcrumbs $breadcrumbs): Response
    {
        $lectures = new Lectures();
        $form = $this->createForm(LectureFormType::class, $lectures);
        $links = ['Главная' => "/", 'Лекции' => "/lecture/list", 'Создать лекцию' => ""];
        $this->createBreadcrumb($links, $breadcrumbs);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $lectures = $form->getData();
            $manager->persist($lectures);
            $manager->flush();
            return $this->redirectToRoute('lectures_list');
        }
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