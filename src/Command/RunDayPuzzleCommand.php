<?php

namespace AdventOfCode\Command;

use AdventOfCode\API\AdventOfCodeAPI;
use AdventOfCode\Factory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class RunDayPuzzleCommand extends Command
{
    protected static $defaultName = 'puzzle:run';

    private $output;

    protected function configure()
    {
        $this
            ->addArgument('day')
            ->addArgument('part')
            ->addOption('year', null, InputOption::VALUE_REQUIRED)
            ->addOption('file', 'f', InputOption::VALUE_REQUIRED)
            ->addOption('test', 't', InputOption::VALUE_NONE)
            ->addOption(
                'send',
                null,
                InputOption::VALUE_NONE,
                <<<DESCRIPTION
Evaluate Test Results and all tests pass - run puzzle with input data and send value to adventofcode.com
DESCRIPTION
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->output = $output;
        $day = $input->getArgument('day');
        $part = $input->getArgument('part');
        $file = $input->getOption('file');
        $sendResult = $input->getOption('send');
        $year = $input->getOption('year');
        if (empty($year)) {
            $year = (new \DateTime())->format('Y');
        }

        $fileData = null;
        if ($file !== null) {
            $fileData = file_get_contents($file);
        }

        $testPassed = null;
        $result = null;

        if ($input->getOption('test')) {
            $testPassed = $this->runTests($year, $day, $part);
        } else {
            $result = $this->runPuzzleWithInput($year, $day, $part, $fileData);
        }

        if ($sendResult) {
            if (null === $testPassed) {
                $testPassed = $this->runTests($year, $day, $part);
            }

            if ($testPassed) {
                $output->writeln(sprintf('<info>All tests passed!</info>'));
                if (null === $result) {
                    $result = $this->runPuzzleWithInput($year, $day, $part, $fileData);
                }

                $output->writeln(sprintf('<info>Sending result...</info>'));
                AdventOfCodeAPI::sendPuzzleAnswer($year, $day, $part, $result);

                $output->writeln(sprintf('<info>Sent!</info>'));
            } else {
                $output->writeln(sprintf('<error>Tests did not passed, result is not sent!</error>'));
            }
        }

        return 0;
    }

    private function runPuzzleWithInput($year, $day, $part, $fileData)
    {
        $result = Factory::getDaysManager($year)->runDayPuzzle($day, $part, $fileData);

        $this->output->writeln('<info>Result: ' . $result++ . '</info>');

        return $result;
    }

    private function runTests($year, $day, $part): bool
    {
        $testNumber = 1;
        $testPassed = true;
        foreach (Factory::getDaysManager($year)->getTests($day, $part) as $answer => $testInput) {
            $result = (string)Factory::getDaysManager($year)->runDayPuzzle($day, $part, $testInput);
            if ($result === $answer) {
                $this->output->writeln('<info>Test ' . $testNumber++ . ' success!</info>');
            } else {
                $testPassed = false;
                $this->output->writeln(
                    '<error>'
                    . 'Test ' . $testNumber++ . ' failed!'
                    . ' Expected: ' . $answer . ' received: ' . $result
                    . '</error>'
                );
            }
        }

        return $testPassed;
    }
}