<?php

namespace AdventOfCode\Command;

use AdventOfCode\API\AdventOfCodeAPI;
use AdventOfCode\Factory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class DownloadPuzzleInputCommand extends Command
{
    protected static $defaultName = 'puzzle:download:input';

    protected function configure()
    {
        $this
            ->setAliases(['p:d:i'])
            ->addArgument('day')
            ->addOption('year', 'y', InputOption::VALUE_REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $day = $input->getArgument('day');
        $year = $input->getOption('year');
        if (empty($year)) {
            $year = (new \DateTime())->format('Y');
        }

        Factory::getDayPuzzleGenerator($year)->populateInputFile($day, AdventOfCodeAPI::getPuzzleInput($year, $day));

        $output->writeln('Input file populated');
    }
}