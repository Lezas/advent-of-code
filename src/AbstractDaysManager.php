<?php

namespace AdventOfCode;

abstract class AbstractDaysManager implements DaysManagerInterface
{
    abstract public static function getNamespace(): string;

    abstract public static function getBaseDir(): string;

    public function runDayPuzzle(int $day, string $part, ?string $input = null)
    {
        if (null === $input) {
            $input = file_get_contents($this->getDayInputFile($day));
        }

        return $this->runPuzzle($day, $part, $input);
    }

    public function getTests(int $day, string $part): iterable
    {
        $class = $this->getDayPuzzleTest($day);

        switch ($part) {
            case 'first':
                yield from (new $class)->testFirstPart();
                break;
            case 'second':
                yield from (new $class)->testSecondPart();
                break;
            default:
                throw new \Exception(sprintf('undefined part %s', $part));
        }
    }

    private function getDayPuzzle(int $day): PuzzleInterface
    {
        $class = sprintf('%s\Day%s\Puzzle', $this->getNamespace(), $day);

        if (!class_exists($class)) {
            throw new \Exception(sprintf('Class "%s" for day %s Not Found', $class, $day));
        }

        return new $class;
    }

    private function getDayPuzzleTest(int $day): TestInterface
    {
        $class = sprintf('%s\Day%s\PuzzleTest', $this->getNamespace(), $day);

        if (!class_exists($class)) {
            throw new \Exception(sprintf('Class "%s" for day %s Not Found', $class, $day));
        }

        return new $class;
    }

    private function runPuzzle(int $day, string $part, string $input)
    {
        $class = $this->getDayPuzzle($day);

        switch ($part) {
            case 'first':
                return (new $class)->firstPart($input);
            case 'second':
                return (new $class)->secondPart($input);
            default:
                throw new \Exception(sprintf('undefined part %s', $part));
        }
    }

    private function getDayInputFile(int $day): string
    {
        $inputFile = $this->getBaseDir() . "/Day{$day}/input.txt";
        if (!\file_exists($inputFile)) {
            throw new \Exception("Input file '{$inputFile}' does not exists");
        }

        return $inputFile;
    }
}