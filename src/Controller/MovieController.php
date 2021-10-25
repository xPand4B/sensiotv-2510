<?php

namespace App\Controller;

use App\Helper\OmdbApi;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/movie', name: 'movie.')]
class MovieController extends AbstractController
{
    #[Route('/{id}', name: 'show', requirements: ['id' => '\d+'], methods: 'GET')]
    public function show(int $id): Response
    {
        return $this->render('movie/show.html.twig');
    }

    #[Route('/latest', name: 'latest', methods: 'GET')]
    public function latest(): Response
    {
        return $this->render('movie/latest.html.twig');
    }

    #[Route('/search', name: 'search', methods: 'GET')]
    public function search(Request $request, OmdbApi $omdbApi): Response
    {
        $searchResults = [];

        if ($term = $request->query->get('term')) {
            $searchResults = $omdbApi->requestAllBySearch($term);
        }

        return $this->render('movie/search.html.twig', compact('term', 'searchResults'));
    }
}
