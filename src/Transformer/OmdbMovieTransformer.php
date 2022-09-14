<?php

namespace App\Transformer;

use App\Entity\Genre;
use App\Entity\Movie;
use App\Repository\GenreRepository;
use Symfony\Component\Form\DataTransformerInterface;

class OmdbMovieTransformer implements DataTransformerInterface
{
    private GenreRepository $genreRepository;

    public function __construct(GenreRepository $genreRepository)
    {
        $this->genreRepository = $genreRepository;
    }

    public function transform($value)
    {
        $date = $value['Released'] === 'N/A' ? $value['Year'] : $value['Released'];
        $genreNames = explode(', ', $value['Genre']);

        $movie = (new Movie())
            ->setTitle($value['Title'])
            ->setCountry($value['Country'])
            ->setPoster($value['Poster'])
            ->setReleasedAt(new \DateTimeImmutable($date))
            ->setPrice(5.0)
            ->setImdbId($value['imdbID'])
            ->setRated($value['Rated'])
            ;

        foreach ($genreNames as $genreName) {
            $genre = $this->genreRepository->findOneBy(['name' => $genreName]) ?? (new Genre())->setName($genreName);
            $movie->addGenre($genre);
        }

        return $movie;
    }

    public function reverseTransform($value)
    {
        throw new \LogicException('Not implemented.');
    }
}