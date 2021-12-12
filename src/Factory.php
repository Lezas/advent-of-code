<?php

namespace AdventOfCode;

class Factory
{
    public static function getDaysManager(int $year): DaysManagerInterface
    {
        $class = sprintf('%s\Year%s\DaysManager', __NAMESPACE__, $year);

        if (!class_exists($class)) {
            throw new \Exception(sprintf('Class "%s" for year %s Not Found', $class, $year));
        }

        return new $class;
    }

    public static function getDayPuzzleGenerator(int $year): PuzzleGeneratorInterface
    {
        $class = sprintf('%s\Year%s\DayPuzzleGenerator', __NAMESPACE__, $year);

        if (!class_exists($class)) {
            throw new \Exception(sprintf('Class "%s" for year %s Not Found', $class, $year));
        }

        return new $class;
    }
}