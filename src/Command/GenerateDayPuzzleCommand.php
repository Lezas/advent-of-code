<?php

namespace AdventOfCode\Command;

use AdventOfCode\Factory;
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
            ->setAliases(['p:g'])
            ->addArgument('day')
            ->addOption('year', 'y', InputOption::VALUE_REQUIRED)
            ->addOption('force', 'f', InputOption::VALUE_NONE);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $year = $input->getOption('year');
        if (empty($year)){
            $year = (new \DateTime())->format('Y');
        }
        $day = $input->getArgument('day');
        $force = $input->getOption('force');

        Factory::getDayPuzzleGenerator($year)->generateDay($day, $force);

        $output->writeln('Puzzle Generated');
    }
}