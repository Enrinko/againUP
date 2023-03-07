<?php

namespace App\Controller;

use App\Entity\Answers;
use App\Entity\Lectures;
use App\Entity\Questions;
use App\Entity\Tests;
use App\Entity\User;
use App\Form\LectureFormType;
use App\Form\TestFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;

class AdminController extends AbstractController
{
    #[Route('/admin', name:'admin')]
    public function admin(
        EntityManagerInterface $manager,
        Request $request,
        Breadcrumbs $breadcrumbs
    ): Response
    {
        $links = ['Главная' => "/", 'Личный кабинет' => "/userCab", 'Админ панель' => ""];
        $all = $manager->getRepository(User::class)->findAll();
        $this->createBreadcrumb($links, $breadcrumbs);
        $query = $request->get('users');
        if (sizeof($query) != 0) {
            foreach ($query as $user => $role) {
                $oldUser = $manager->getRepository(User::class)->findBy(['username' => $user]);
                $oldUser->setRoles([$role]);
                $manager->flush();
            }
        }
        $array = [
            'this' => 'Создать лекцию',
            'users' => $all,
            'roles' => [
                0 => 'ROLE_USER',
                1 => 'ROLE_EDITOR',
                2 => 'ROLE_ADMIN',
            ],

        ];
        return $this->render('admin.html.twig', $array);
    }

    public function createBreadcrumb(
        $array,
        $breadcrumbs
    )
    {
        foreach ($array as $name => $link) {
            $breadcrumbs->addItem($name, $link);
        }
    }

    #[Route('/create/lecture', name:'addLecture', priority: 1)]
    public function createLecture(
        EntityManagerInterface $manager,
        Request $request,
        Breadcrumbs $breadcrumbs
    ): Response
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

    #[Route('/edit/lecture/{id}', name:'editLecture')]
    public function editLecture(
        EntityManagerInterface $manager,
        Request $request,
        Breadcrumbs $breadcrumbs,
        int $id
    ): Response
    {
        $lectures = $manager->getRepository(Lectures::class)->find($id);
        $form = $this->createForm(LectureFormType::class, $lectures);
        $links = ['Главная' => "/", 'Лекции' => "/lecture/list", 'Отредактировать лекцию' => ""];
        $this->createBreadcrumb($links, $breadcrumbs);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->flush();
            return $this->redirectToRoute('lectures_list');
        }
        $array = [
            'form' => $form,
            'this' => 'Отредактировать лекцию',
        ];
        return $this->render('add-edit-lecture.html.twig', $array);
    }
    #[Route('/delete/lecture/{id}', name:'deleteLecture')]
    public function deleteLecture(
        EntityManagerInterface $manager,
        int $id
    ): Response
    {
        $manager->getRepository(Lectures::class)->remove($manager->getRepository(Lectures::class)->find($id), true);
        return $this->redirectToRoute('lectures_list');
    }

    #[Route('/create/test', name:'addTest', priority: 30)]
    public function createTest(
        EntityManagerInterface $manager,
        Request $request,
        Breadcrumbs $breadcrumbs,
    ): Response
    {
        $test = new Tests();
        $test->setName("");
        $form = $this->createForm(TestFormType::class, $test);
        $links = ['Главная' => "/", 'Тесты' => "/test/list", 'Создать тест' => ""];
        $this->createBreadcrumb($links, $breadcrumbs);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $test = $form->getData();
            $manager->persist($test);
            $manager->flush();
            return $this->redirectToRoute('tests_list');
        }
        $array = [
            'this' => 'Создать тест',
            'form' => $form,
        ];
        return $this->render('add-edit-test.html.twig', $array);
    }

    #[Route('/delete/test/{id}', name:'deleteTest')]
    public function deleteTest(EntityManagerInterface $manager, int $id): Response
    {
        $manager->getRepository(Tests::class)->remove($manager->getRepository(Tests::class)->find($id), true);
        return $this->redirectToRoute('tests_list');
    }
}