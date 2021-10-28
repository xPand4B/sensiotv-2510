<?php

namespace App\Controller;

use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'home', methods: ['GET'])]
    public function index(MovieRepository $movieRepository): Response
    {
        $movies = $movieRepository->findBy(
            [], ['releaseDate' => 'DESC'], 6
        );

        return $this->render('homepage.html.twig', compact('movies'));
    }
}
