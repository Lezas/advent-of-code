<?php

namespace AdventOfCode;

use AdventOfCode\Year2021\DaysManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class RunDayPuzzleCommand extends Command
{
    protected static $defaultName = 'run:day';

    protected function configure()
    {
        $this
            ->addArgument('day')
            ->addArgument('part')
            ->addArgument('file')
            ->addOption('file', 'f', InputOption::VALUE_REQUIRED)
            ->addOption('demo', 'd', InputOption::VALUE_NONE);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $day = $input->getArgument('day');
        $part = $input->getArgument('part');
        $file = $input->getOption('file');

        if ($input->getOption('demo')) {
            $result = DaysManager::runDayPuzzleDemo($day, $part, $file);
        } else {
            $result = DaysManager::runDayPuzzle($day, $part, $file);
        }

        $output->writeln('Result: ' . $result);
    }
}