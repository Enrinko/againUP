<?php

namespace App\Controller;

use App\Entity\Tests;
use App\Entity\TestsOfUser;
use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Service\MyValidator;
use App\Service\PublicForm;
use App\Service\PublicService;
use App\Service\SetUser;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class SiteController extends AbstractController
{
    public LoggerInterface $logger;
    public EntityManagerInterface $manager;


    public function __construct(LoggerInterface $logger, EntityManagerInterface $manager)
    {
        $this->logger = $logger;
        $this->manager = $manager;
    }
    #[Route('/', name: "mainPage")]
    public function index(): Response
    {
        $array = [
            'layers' => 0,
            'links' => [],
            'this' => 'Главная',
            'isBought' => false,
            'isLoged' => false
        ];
        return $this->render('index.html.twig', $array);
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
    public function userCab(PublicService $service): Response
    {
        $array = [
            'username' => $this->getUser()->getUserIdentifier(),
            'role' => $service->identifyRole(),
            'course' => $this->isGranted('ROLE_PREMIUM')? 'TechLand Plus' : 'TechLand Base',
            'layers' => 1,
            'links' => [
                'Главная' => "path('mainPage')"
            ],
            'tests' => $this->manager->getRepository(TestsOfUser::class)
                    ->count(['User' => $this->getUser()])
                .'/'.
                $this->manager->getRepository(Tests::class)->count(['id' => '?']),
            'this' => 'Личный кабинет',
            'isBought' => false,
            'isLoged' => false
        ];
        return $this->render('userCab.html.twig', $array);
    }

    #[Route('/reg', name: "reg")]
    public function reg(Request $request, PublicForm $userForm, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response
    {
        $form = $userForm->create(RegistrationFormType::class);
        $user = new User();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setUsername($form->get('username')->getData());
            $user->setPassword(
                $passwordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            $user->setRoles(['ROLE_USER']);
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('mainPage');
        }
        $array = [
            'form' => $form->createView(),
            'title' => 'Зарегистрируйтесь',
            'text' => 'Уже есть аккаунт? Войдите!',
            'toWhere' => 'login'
        ];
        return $this->render('auth.html.twig', $array);
    }

    #[Route(path: '/login', name: 'login', methods: ['GET', 'POST'])]
    public function login(Request $request, PublicForm $userForm): Response
    {
        $form = $userForm->create(RegistrationFormType::class);
        $errors = "";
        $form->handleRequest($request);
        if ($this->getUser()) {
            return $this->redirectToRoute('mainPage');
        }
        $array = [
            'form' => $form->createView(),
            'title' => 'Войти',
            'text' => 'Нет аккаунта? Зарегистрируйтесь!',
            'toWhere' => 'reg',
            'errors' => $errors,
            'method' => 'POST'
        ];
        return $this->render('auth.html.twig', $array);
    }

    #[Route('/logout', name: "logout", methods: ['GET'])]
    public function logout(): int
    {
    }
}