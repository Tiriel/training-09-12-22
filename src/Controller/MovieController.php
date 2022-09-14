<?php

namespace App\Controller;

use App\Consumer\OmdbApiConsumer;
use App\Repository\MovieRepository;
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
    public function index(MovieRepository $repository, int $moviePerPage): Response
    {
        return $this->render('movie/index.html.twig', [
            'movies' => $repository->findBy([], [], $moviePerPage)
        ]);
    }

    /**
     * @Route("/{!id<\d+>?1}", name="details")
     */
    public function details(MovieRepository $repository, int $id = 1): Response
    {
        $movie = $repository->find($id);

        return $this->render('movie/details.html.twig', [
            'movie' => $movie,
        ]);
    }

    /**
     * @Route("/omdb/{title<[a-zA-z0-9- ]+>}", name="details_title")
     */
    public function detailsByTitle(string $title, OmdbApiConsumer $consumer): Response
    {
        dump($consumer->getMovie(OmdbApiConsumer::MODE_TITLE, $title));

        return $this->render('movie/details.html.twig', [
            'movie' => [],
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
