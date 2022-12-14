<?php

namespace {{{namespace}}};

use AdventOfCode\PuzzleInterface;

class Puzzle implements PuzzleInterface
{
    public function firstPart(string $input)
    {
        $lines = explode("\n", trim($input));
        $map = [];

        foreach ($lines as $line) {
            $map[] = trim($line);
            //modify each line according to your needs
        }

        //Logic goes here
        $result = 0;

        return $result;
    }

    public function secondPart(string $input)
    {
        $lines = explode("\n", trim($input));
        $map = [];

        foreach ($lines as $line) {
            $map[] = trim($line);
            //modify each line according to your needs
        }

        //Logic goes here
        $result = 0;

        return $result;
    }
}