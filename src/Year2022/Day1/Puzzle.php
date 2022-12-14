<?php

namespace AdventOfCode\Year2022\Day1;

use AdventOfCode\PuzzleInterface;

class Puzzle implements PuzzleInterface
{
    public function firstPart(string $input)
    {
        $elfsCalories = explode("\n\n", trim($input));

        $calories = array_map(function ($elfsCalory) {
            return array_sum(array_map(function ($number) {
                return (int)trim($number);
            }, explode("\n", trim($elfsCalory))));
        }, $elfsCalories);

        return max($calories);
    }

    public function secondPart(string $input)
    {
        $elfsCalories = explode("\n\n", trim($input));

        $calories = array_map(function ($elfsCalory) {
            return array_sum(array_map(function ($number) {
                return (int)trim($number);
            }, explode("\n", trim($elfsCalory))));
        }, $elfsCalories);

        rsort($calories);

        return array_sum(array_slice($calories, 0, 3));
    }
}
