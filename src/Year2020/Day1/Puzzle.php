<?php

namespace AdventOfCode\Year2020\Day1;

use AdventOfCode\PuzzleInterface;

class Puzzle implements PuzzleInterface
{
    public function firstPart(string $input)
    {
        $lines = explode("\n", trim($input));

        $count = count($lines);
        for ($i = 0; $i < $count; $i++) {
            for ($j = $i + 1; $j < $count; $j++) {
                if (((int)$lines[$i] + (int)$lines[$j]) === 2020) {
                    return (int)$lines[$i] * (int)$lines[$j];
                }
            }
        }

        //Logic goes here
        $result = 0;

        return $result;
    }

    public function secondPart(string $input)
    {
        $lines = explode("\n", trim($input));

        $count = count($lines);
        for ($i = 0; $i < $count; $i++) {
            for ($j = $i + 1; $j < $count; $j++) {
                for ($o = $j + 1; $o < $count; $o++) {
                    if (((int)$lines[$i] + (int)$lines[$j] + (int)$lines[$o]) === 2020) {
                        return (int)$lines[$i] * (int)$lines[$j] * (int)$lines[$o];
                    }
                }
            }
        }

        //Logic goes here
        $result = 0;

        return $result;
    }
}