<?php

namespace AdventOfCode\Year2021\Day1;

use AdventOfCode\PuzzleInterface;

class Puzzle implements PuzzleInterface
{
    public function firstPart(string $input)
    {
        $numbers = array_map(function ($number) {
            return (int)trim($number);
        }, explode("\n", trim($input)));

        $count = count($numbers);

        $increased = 0;
        for ($i = 0; $i < ($count - 1); $i++) {
            if ($numbers[$i + 1] > $numbers[$i]) {
                $increased++;
            }
        }

        return $increased;
    }

    public function secondPart(string $input)
    {
        $numbers = array_map(function ($number) {
            return (int)trim($number);
        }, explode("\n", trim($input)));

        $count = count($numbers);

        $increased = 0;
        for ($i = 1; $i < ($count - 2); $i++) {
            $number1 = $numbers[$i - 1] + $numbers[$i] + $numbers[$i + 1];
            $number2 = $numbers[$i] + $numbers[$i + 1] + $numbers[$i + 2];
            if ($number1 < $number2) {
                $increased++;
            }
        }

        return $increased;
    }
}