<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class BookFindCommand extends Command
{
    protected static $defaultName = 'app:book:find';
    protected static $defaultDescription = 'Add a short description for your command';

    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::REQUIRED, 'Argument description')
            ->addArgument('arg2', InputArgument::REQUIRED, 'Argument description')
            ->addArgument('arg3', InputArgument::REQUIRED|InputArgument::IS_ARRAY, 'Argument description')
            ->addOption('option1', 'o', InputOption::VALUE_OPTIONAL, 'Option description')
            ->addOption('option2', 'p', InputOption::VALUE_NONE, 'Option description')
            ->addOption('option3', 'r', InputOption::VALUE_OPTIONAL, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $arg1 = $input->getArgument('arg1');
        $arg2 = $input->getArgument('arg2');
        $arg3 = $input->getArgument('arg3');
        //$option1 = $input->getOption('option1');

        if ($arg1) {
            $io->title(sprintf('You passed a first argument: %s', $arg1));
        }

        if ($arg2) {
            $io->text(sprintf('You passed a second argument: %s', $arg2));
        }

        if ($arg3) {
            $io->note(sprintf('You passed a third argument: %s', implode(', ', $arg3)));
        }

        if ($input->getOption('option2')) {
            $io->error('You passed option2!!!');
        }

        //if ($option1) {
        //    $io->note(sprintf('You passed an option: %s', implode(', ', $option1)));
        //}

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }
}
