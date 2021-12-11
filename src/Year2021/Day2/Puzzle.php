<?php

namespace AdventOfCode\Year2021\Day2;

use AdventOfCode\PuzzleInterface;

class Puzzle implements PuzzleInterface
{
    public function firstPart(string $input)
    {
        $lines = explode("\n", trim($input));

        $depth = 0;
        $forward = 0;

        foreach ($lines as $line) {
            preg_match('/(?<name>[a-z]+)+ (?<value>[0-9]+)/', $line, $matches);

            switch ($matches['name']) {
                case 'forward':
                    $forward += $matches['value'];
                    break;
                case 'up':
                    $depth -= $matches['value'];
                    break;
                case 'down':
                    $depth += $matches['value'];
                    break;
            }
        }

        return ($depth * $forward);
    }

    public function secondPart(string $input)
    {
        $lines = explode("\n", trim($input));

        $aim = 0;
        $depth = 0;
        $forward = 0;

        foreach ($lines as $line) {
            preg_match('/(?<name>[a-z]+)+ (?<value>[0-9]+)/', $line, $matches);

            switch ($matches['name']) {
                case 'forward':
                    $forward += $matches['value'];
                    $depth += $aim * $matches['value'];
                    break;
                case 'up':
                    $aim -= $matches['value'];
                    break;
                case 'down':
                    $aim += $matches['value'];
                    break;
            }
        }

        return ($depth * $forward);
    }
}