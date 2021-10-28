<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Helper\OmdbApi;
use App\Repository\MovieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

#[Route('/movie', name: 'movie.')]
class MovieController extends AbstractController
{
    public function __construct(
        private OmdbApi $omdbApi,
        private EntityManagerInterface $entityManager,
        private MovieRepository $movieRepository
    ){
    }

    /**
     * This Method has automatic "Route Entity Binding".
     * @see https://symfony.com/bundles/SensioFrameworkExtraBundle/current/annotations/converters.html
     */
    #[Route('/{id}', name: 'show', requirements: ['id' => '\d+'], methods: 'GET')]
    public function show(Movie $movie): Response
    {
        $this->denyAccessUnlessGranted(
            'MOVIE_SHOW', $movie, 'You can only view Movies younger than you.'
        );

        return $this->render('movie/show.html.twig', compact('movie'));
    }

    #[Route('/latest', name: 'latest', methods: 'GET')]
    public function latest(): Response
    {
//        $movies = $this->movieRepository->findAll();
        $movies = $this->movieRepository->findBy(
            [], ['releaseDate' => 'DESC'], 20
        );

        return $this->render('movie/latest.html.twig', compact('movies'));
    }

    #[Route('/search', name: 'search', methods: 'GET')]
    public function search(Request $request): Response
    {
        $searchResults = [];

        if ($term = $request->query->get('term', 'Harry Potter')) {
            $searchResults = $this->omdbApi->requestAllBySearch($term);
        }

        return $this->render('movie/search.html.twig', compact('term', 'searchResults'));
    }

    #[Route('/{imdbID}/import', name: 'import', requirements: ['imdbID' => 'tt\d+'], methods: 'GET')]
    public function import(string $imdbID): Response
    {
        $this->denyAccessUnlessGranted('ROLE_MOVIE_IMPORT');
//        if (!$this->isGranted('ROLE_USER')) {
//            throw new AccessDeniedException();
//        }

        $result = $this->omdbApi->requestOneById($imdbID);
        $movie = Movie::fromApi($result);
        $this->entityManager->persist($movie);
        $this->entityManager->flush();

        return $this->redirectToRoute('movie.latest');
    }
}
