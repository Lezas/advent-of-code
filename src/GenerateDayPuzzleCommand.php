<?php

namespace AdventOfCode;

use AdventOfCode\Year2021\DayPuzzleGenerator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateDayPuzzleCommand extends Command
{
    protected static $defaultName = 'puzzle:generate';

    protected function configure()
    {
        $this
            ->addArgument('day')
            ->addOption('force', 'f', InputOption::VALUE_NONE);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $day = $input->getArgument('day');
        $force = $input->getOption('force');

        DayPuzzleGenerator::generateDay($day, $force);

        $output->writeln('Puzzle Generated');
    }
}