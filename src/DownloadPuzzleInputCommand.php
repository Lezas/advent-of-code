<?php

namespace AdventOfCode;

use AdventOfCode\Year2021\DayPuzzleGenerator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DownloadPuzzleInputCommand extends Command
{
    protected static $defaultName = 'puzzle:download:input';

    protected function configure()
    {
        $this
            ->addArgument('day');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $day = $input->getArgument('day');

        DayPuzzleGenerator::populateInputFile($day, AdventOfCodeAPI::getPuzzleInput(2021, $day));

        $output->writeln('Input file populated');
    }
}