<?php namespace App\Controller;

use App\Entity\Lectures;
use App\Entity\Tests;
use App\Entity\TestsOfUser;
use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Service\IdentifyService;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Component\Security\Http\Authenticator\FormLoginAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\RememberMeBadge;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;

class SiteController extends AbstractController
{
    private EntityManagerInterface $manager;

    public function __construct(
        EntityManagerInterface $manager,
        private FormLoginAuthenticator $authenticator
    )
    {
        $this->manager = $manager;
    }

    #[Route('/', name: "mainPage")]
    public function index(
        Breadcrumbs $breadcrumbs
    ): Response
    {
        $links = ['Главная' => ""];
        $this->createBreadcrumb($links, $breadcrumbs);
        $array = [
            'this' => 'Главная',
            ];
        return $this->render('index.html.twig', $array);
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

    #[Route('/lecture/list', name: "lectures_list", priority: 1)]
    public function lectures_list(
        Breadcrumbs $breadcrumbs
    ): Response
    {
        $links = ['Главная' => "/", 'Лекции' => ""];
        $this->createBreadcrumb($links, $breadcrumbs);
        $array = [
            'this' => 'Лекции',
            'lectures' => $this->manager->getRepository(Lectures::class)->findAll()
        ];
        return $this->render('lectures.html.twig', $array);
    }

    #[Route('/lecture/{id}', name: "lecture")]
    public function showLecture(
        EntityManagerInterface $manager,
        Breadcrumbs $breadcrumbs,
        int $id
    ): Response
    {
        $links = ['Главная' => "/", 'Лекции' => "/lecture/list", 'Лекция' => ""];
        $this->createBreadcrumb($links, $breadcrumbs);
        $array = [
            'this' => 'Лекция',
            'lecture' => $manager->getRepository(Lectures::class)->find($id)
        ];
        return $this->render('lecture.html.twig', $array);
    }

    #[Route('/test/list', name: "tests_list", priority: 1)]
    public function tests_list(
        Breadcrumbs $breadcrumbs
    ): Response
    {
        $links = ['Главная' => "/", 'Тесты' => ""];
        $this->createBreadcrumb($links, $breadcrumbs);
        $array = [
            'this' => 'Тесты',
            ];
        return $this->render('tests.html.twig', $array);
    }

    #[Route('/test/{id}', name: "test")]
    public function showTest
    (Breadcrumbs $breadcrumbs,
     int $id
    ): Response
    {
        $links = ['Главная' => "/", 'Тесты' => "/test/list", 'Тест' => ""];
        $this->createBreadcrumb($links, $breadcrumbs);
        $array = [
            'this' => 'Тест',
            ];
        return $this->render('test.html.twig', $array);
    }

    #[Route('/about', name: "about")]
    public function about(
        Breadcrumbs $breadcrumbs
    ): Response
    {
        $links = ['Главная' => "/", 'О нас' => ""];
        $this->createBreadcrumb($links, $breadcrumbs);
        $array = [
            'tests' => $this->manager->getRepository(TestsOfUser::class)->count(['User' => $this->getUser()])
            . '/' .
            $this->manager->getRepository(Tests::class)->count(['id' => '?']),
            'this' => 'О нас',
            ];
        return $this->render('about.html.twig', $array);
    }

    #[Route('/userCab', name: "cab")]
    public function userCab(
        IdentifyService $service, Breadcrumbs $breadcrumbs
    ): Response
    {
        $links = ['Главная' => "/", 'Личный кабинет' => ""];
        $this->createBreadcrumb($links, $breadcrumbs);
        $array = [
            'username' => $this->getUser()->getUserIdentifier(), 'role' => $service->identifyRole(),
            'tests' => $this->manager->getRepository(TestsOfUser::class)->count(['User' => $this->getUser()])
                . '/' .
                $this->manager->getRepository(Tests::class)->count(['id' => '?']),
            'this' => 'Личный кабинет',
            ];
        return $this->render('userCab.html.twig', $array);
    }

    #[Route('/reg', name: "reg")]
    public function reg(
        Request $request,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher,
        UserAuthenticatorInterface $authenticator,
        LoggerInterface $logger
    ): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user->setUsername($form->get('username')->getData());
            $user->setPassword($passwordHasher->hashPassword($user, $form->get('password')->getData()));
            $user->setRoles(['ROLE_USER']);
            $entityManager->persist($user);
            $entityManager->flush();
            $rememberMe = new RememberMeBadge();
            $rememberMe->enable();
            $authenticator->authenticateUser($user, $this->authenticator, $request, [$rememberMe]);
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
    public function login(
        Request $request,
    ): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $array = [
            'form' => $form->createView(),
            'title' => 'Войти',
            'text' => 'Нет аккаунта? Зарегистрируйтесь!',
            'toWhere' => 'reg',
            'method' => 'POST'
        ];
        return $this->render('auth.html.twig', $array);
    }

    public function checkCaptcha($logger,$form) {

    }

    #[Route('/logout', name: "logout", methods: ['GET'])]
    public function logout(): int
    {
    }
}