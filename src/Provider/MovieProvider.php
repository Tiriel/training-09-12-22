<?php

namespace App\Provider;

use App\Consumer\OmdbApiConsumer;
use App\Entity\Movie;
use App\Repository\MovieRepository;
use App\Transformer\OmdbMovieTransformer;

class MovieProvider
{
    private OmdbApiConsumer $consumer;
    private OmdbMovieTransformer $transformer;
    private MovieRepository $repository;

    public function __construct(OmdbApiConsumer $consumer, OmdbMovieTransformer $transformer, MovieRepository $repository)
    {
        $this->consumer = $consumer;
        $this->transformer = $transformer;
        $this->repository = $repository;
    }

    public function getMovieByTitle(string $title): Movie
    {
        $movie = $this->transformer->transform(
            $this->consumer->getMovie(OmdbApiConsumer::MODE_TITLE, $title)
        );

        if ($entityMovie = $this->repository->findOneBy(['title' => $movie->getTitle()])) {
            return $entityMovie;
        }

        $this->repository->add($movie, true);

        return $movie;
    }
}