<?php

namespace App\Provider;

use App\Consumer\OmdbApiConsumer;
use App\Entity\Movie;
use App\Repository\MovieRepository;
use App\Transformer\OmdbMovieTransformer;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Security\Core\Security;

class MovieProvider
{
    private OmdbApiConsumer $consumer;
    private OmdbMovieTransformer $transformer;
    private MovieRepository $repository;
    private ?SymfonyStyle $io = null;
    private Security $security;

    public function __construct(OmdbApiConsumer $consumer, OmdbMovieTransformer $transformer, MovieRepository $repository, Security $security)
    {
        $this->consumer = $consumer;
        $this->transformer = $transformer;
        $this->repository = $repository;
        $this->security = $security;
    }

    public function getMovieByTitle(string $title): Movie
    {
        return $this->doGetMovie(OmdbApiConsumer::MODE_TITLE, $title);
    }

    public function getMovieBytId(string $id): Movie
    {
        return $this->doGetMovie(OmdbApiConsumer::MODE_ID, $id);
    }

    public function setSymfonyStyle(SymfonyStyle $io)
    {
        $this->io = $io;
    }

    private function doGetMovie(string $type, string $value): Movie
    {
        $this->sendIo('text', "Searching on OMDb API");
        $movie = $this->transformer->transform(
            $this->consumer->getMovie($type, $value)
        );

        if ($entityMovie = $this->repository->findOneBy(['title' => $movie->getTitle()])) {
            $this->sendIo('note', "Movie found in database.");
            return $entityMovie;
        }

        $this->sendIo('text', "Movie found on OMDb API. Adding in database.");
        $movie->setAddedBy($this->security->getUser());
        $this->repository->add($movie, true);

        return $movie;
    }

    private function sendIo(string $type, string $message)
    {
        if ($this->io && \method_exists(SymfonyStyle::class, $type)) {
            $this->io->$type($message);
        }
    }
}