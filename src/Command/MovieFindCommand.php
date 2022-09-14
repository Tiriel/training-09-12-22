<?php

namespace App\Command;

use App\Entity\Movie;
use App\Provider\MovieProvider;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class MovieFindCommand extends Command
{
    protected static $defaultName = 'app:movie:find';
    protected static $defaultDescription = 'Add a short description for your command';
    private MovieProvider $provider;

    public function __construct(MovieProvider $provider, string $name = null)
    {
        parent::__construct($name);
        $this->provider = $provider;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('value', InputArgument::OPTIONAL, 'The value you are searching for (the IMDb ID or title of the movie).')
            ->addArgument('type', InputArgument::OPTIONAL, "The type of search you want to perform ('id'or 'title').")
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $this->provider->setSymfonyStyle($io);

        if (!$value = $input->getArgument('value')) {
            $value = $io->ask('What is the value you are searching for?');
        }

        $type = $input->getArgument('type');
        while (!\in_array($type, ['id', 'title'])) {
            $type = $io->ask(sprintf("Is \"%s\" an id or a title? ('id'or 'title')", $value));
        }

        $method = 'getMovieBy' . ucfirst($type);
        if (!\method_exists(MovieProvider::class, $method)) {
            throw new \RuntimeException(sprintf("Method \"%s\" doesn't exist.", $method));
        }

        $io->title('Your search :');
        $io->text(sprintf("Searching for a movie with %s \"%s\".", $type, $value));

        try {
            /** @var Movie $movie */
            $movie = $this->provider->$method($value);
        } catch (NotFoundHttpException $e) {
            $io->error('Movie not found.');
            return Command::FAILURE;
        }

        $io->section('Done :');
        $io->table(['Id', 'IMDb ID', 'Title', 'Rated'], [
            [$movie->getId(), $movie->getImdbId(), $movie->getTitle(), $movie->getRated()],
        ]);

        $io->success('Movie in database.');

        return Command::SUCCESS;
    }
}
