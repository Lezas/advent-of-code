<?php

namespace AdventOfCode\Year2022\Day3;

use AdventOfCode\PuzzleInterface;

class Puzzle implements PuzzleInterface
{
    public function firstPart(string $input)
    {
        $lines = explode("\n", trim($input));

        $score = 0;

        foreach ($lines as $line) {
            $line = trim($line);
            $length = strlen($line);
            $halfLength = $length / 2;
            $string1 = str_split(substr($line, 0, $halfLength));
            $string2 = str_split(substr($line, $halfLength));

            $common = implode(array_intersect($string1, $string2));

            if (ctype_lower($common)) {
                $score += ord($common) - 96;
            } else {
                $score += ord($common) - 64 + 26;
            }
        }

        return $score;
    }

    public function secondPart(string $input)
    {
        $lines = explode("\n", trim($input));

        $score = 0;

        $group = [];

        foreach ($lines as $line) {
            $group[] = str_split($line);

            if (count($group) < 3) {
                continue;
            }

            $common = implode(array_intersect(...$group));

            if (ctype_lower($common)) {
                $score += ord($common) - 96;
            } else {
                $score += ord($common) - 64 + 26;
            }

            $group = [];
        }

        return $score;
    }
}
