<?php

namespace App\Controller;

use App\Provider\MovieProvider;
use App\Repository\MovieRepository;
use App\Security\Voter\MovieVoter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/movie", name="app_movie_")
 */
class MovieController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(MovieRepository $repository): Response
    {
        return $this->render('movie/index.html.twig', [
            'movies' => $repository->findAll(),
        ]);
    }

    /**
     * @Route("/{!id<\d+>?1}", name="details")
     */
    public function details(MovieRepository $repository, int $id = 1): Response
    {
        $movie = $repository->find($id);
        $this->denyAccessUnlessGranted(MovieVoter::VIEW, $movie);

        return $this->render('movie/details.html.twig', [
            'movie' => $movie,
        ]);
    }

    /**
     * @Route("/omdb/{title<[a-zA-z0-9- ]+>}", name="omdb")
     */
    public function omdb(string $title, MovieProvider $provider): Response
    {
        $movie = $provider->getMovieByTitle($title);
        $this->denyAccessUnlessGranted(MovieVoter::VIEW, $movie);

        return $this->render('movie/details.html.twig', [
            'movie' => $movie,
        ]);
    }

    public function decades(MovieRepository $repository, string $frameworkVersion)
    {
        $decades = $repository->getDecades();

        dump($frameworkVersion);
        return $this->render('includes/_decades.html.twig', [
            'decades' => $decades
        ]);
    }
}
