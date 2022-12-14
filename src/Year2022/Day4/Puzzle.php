<?php

namespace AdventOfCode\Year2022\Day4;

use AdventOfCode\PuzzleInterface;

class Puzzle implements PuzzleInterface
{
    public function firstPart(string $input)
    {
        $lines = explode("\n", trim($input));
        $map = [];

        $found = 0;
        foreach ($lines as $line) {
            $rawPairs = explode(',', $line);
            $pairs = [];
            foreach ($rawPairs as $pair) {
                $pairs[]  = explode('-', $pair);
            }

            if ($pairs[0][0] >= $pairs[1][0] && $pairs[0][1] <= $pairs[1][1]) {
                $found++;
                continue;
            }

            if ($pairs[0][0] <= $pairs[1][0] && $pairs[0][1] >= $pairs[1][1]) {
                $found++;
                continue;
            }

        }

        //Logic goes here
        $result = 0;

        return $found;
    }

    public function secondPart(string $input)
    {
        $lines = explode("\n", trim($input));
        $map = [];

        $found = 0;
        foreach ($lines as $line) {
            $rawPairs = explode(',', $line);
            $pairs = [];
            foreach ($rawPairs as $pair) {
                $pairs[]  = explode('-', $pair);
            }

            if ($pairs[0][0] >= $pairs[1][0] && $pairs[0][1] <= $pairs[1][1]) {
                $found++;
                continue;
            }

            if ($pairs[0][0] <= $pairs[1][0] && $pairs[0][1] >= $pairs[1][1]) {
                $found++;
                continue;
            }

            if ($pairs[0][0] >= $pairs[1][0] && $pairs[1][1] >= $pairs[0][0]) {
                $found++;
                continue;
            }

            if ($pairs[0][1] <= $pairs[1][1] && $pairs[0][1] >= $pairs[1][0]) {
                $found++;
                continue;
            }

        }

        //Logic goes here
        $result = 0;

        return $found;
    }
}
