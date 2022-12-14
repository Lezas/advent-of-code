<?php

namespace AdventOfCode\Year2022\Day6;

use AdventOfCode\PuzzleInterface;

class Puzzle implements PuzzleInterface
{
    public function firstPart(string $input)
    {
        $line = trim($input);
        $chars = str_split($line);


        $buffer = [];
        foreach ($chars as $key => $char) {
            if (in_array($char, $buffer)) {
                $found = false;
                while (!$found) {
                    $buffChar = array_shift($buffer);
                    if ($buffChar == $char) {
                        $found = true;
                    }
                }
                $buffer[] = $char;
            }
            if (!in_array($char, $buffer)) {
                $buffer[] = $char;
            }

            if (count($buffer) >= 4) {
                return $key + 1;
            }
        }

        return 0;
    }

    public function secondPart(string $input)
    {
        $line = trim($input);
        $chars = str_split($line);


        $buffer = [];
        foreach ($chars as $key => $char) {
            if (in_array($char, $buffer)) {
                $found = false;
                while (!$found) {
                    $buffChar = array_shift($buffer);
                    if ($buffChar == $char) {
                        $found = true;
                    }
                }
                $buffer[] = $char;
            }
            if (!in_array($char, $buffer)) {
                $buffer[] = $char;
            }

            if (count($buffer) >= 14) {
                return $key + 1;
            }
        }

        return 0;
    }
}
