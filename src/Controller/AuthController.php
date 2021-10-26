<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\Type\LoginType;
use App\Form\Type\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class AuthController extends AbstractController
{
    #[Route('/register', name: 'register')]
    public function register(Request $request, UserPasswordHasherInterface $hasher, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(UserType::class/*, null, [
            'validation_group' => ['Default', 'user_add']
        ]*/);

        if ($form->handleRequest($request)->isSubmitted() && $form->isValid()) {
            /** @var User $user */
            $user = $form->getData();

            $hashedPassword = $hasher->hashPassword($user, $user->getPassword());
            $user->setPassword($hashedPassword);

            $manager->persist($user);
            $manager->flush();
        }

        return $this->render('auth/register.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/login', name: 'login')]
    public function login(Request $request): Response
    {
        $form = $this->createForm(LoginType::class);

        if ($form->handleRequest($request)->isSubmitted() && $form->isValid()) {
            /** @var User $user */
            $user = $form->getData();
            dd($user);
        }

        return $this->render('auth/login.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
