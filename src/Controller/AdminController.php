<?php

namespace App\Controller;

use App\Entity\Lectures;
use App\Entity\User;
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
	public function admin(
		EntityManagerInterface $manager,
		Request                $request,
		Breadcrumbs            $breadcrumbs,
	): Response
	{
		$links = ['Главная' => "/", 'Личный кабинет' => "/userCab", 'Админ панель' => ""];
		$this->createBreadcrumb($links, $breadcrumbs);
		$array = [
			'this' => 'Создать лекцию',
			'users' => $manager->getRepository(User::class)->findAll(),
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
		$breadcrumbs,
	)
	{
		foreach ($array as $name => $link) {
			$breadcrumbs->addItem($name, $link);
		}
	}
	
	#[Route('/create/lecture', name:'addLecture', priority:1)]
	public function createLecture(
		EntityManagerInterface $manager,
		Request                $request,
		Breadcrumbs            $breadcrumbs,
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
		Request                $request,
		Breadcrumbs            $breadcrumbs,
		int                    $id,
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
		int                    $id,
	): Response
	{
		$manager->getRepository(Lectures::class)->remove($manager->getRepository(Lectures::class)->find($id), true);
		return $this->redirectToRoute('lectures_list');
	}
}