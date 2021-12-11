<?php

namespace AdventOfCode\Year2021;

use AdventOfCode\PuzzleInterface;

class DaysManager
{
    public static function getDayPuzzle(int $day): PuzzleInterface
    {
        $class = sprintf('%s\Day%s\Puzzle', __NAMESPACE__, $day);

        if (!class_exists($class)) {
            throw new \Exception(sprintf('Class "%s" for day %s Not Found', $class, $day));
        }

        return new $class;
    }

    public static function runDayPuzzle(int $day, string $part, ?string $inputFile = null)
    {
        if (null === $inputFile) {
            $inputFile = self::getDayInputFile($day);
        }

        return self::runPuzzle($day, $part, $inputFile);
    }

    public static function runDayPuzzleDemo(int $day, string $part, ?string $inputFile = null)
    {
        if (null === $inputFile) {
            $inputFile = self::getDayDemoFile($day);
        }

        return self::runPuzzle($day, $part, $inputFile);
    }

    private static function runPuzzle(int $day, string $part, string $inputFile)
    {
        $class = self::getDayPuzzle($day);

        switch ($part) {
            case 'first':
                return (new $class)->firstPart(\file_get_contents($inputFile));
            case 'second':
                return (new $class)->secondPart(\file_get_contents($inputFile));
            default:
                throw new \Exception(sprintf('undefined part %s', $part));
        }
    }

    public static function getDayDemoFile(int $day): string
    {
        $inputFile = __DIR__ . "/Day{$day}/demo.txt";
        if (!\file_exists($inputFile)) {
            throw new \Exception("Demo file '{$inputFile}' does not exists");
        }

        return $inputFile;
    }

    public static function getDayInputFile(int $day): string
    {
        $inputFile = __DIR__ . "/Day{$day}/input.txt";
        if (!\file_exists($inputFile)) {
            throw new \Exception("Input file '{$inputFile}' does not exists");
        }

        return $inputFile;
    }
}