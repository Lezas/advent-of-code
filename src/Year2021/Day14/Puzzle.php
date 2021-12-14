<?php

namespace AdventOfCode\Year2021\Day14;

use AdventOfCode\PuzzleInterface;
use AdventOfCode\Util\InputGenerator;

class Puzzle implements PuzzleInterface
{
    public function firstPart(string $input)
    {
        $polymerLine = null;
        $newLine = null;

        $pairs = [];

        foreach (InputGenerator::inputToLineGenerator($input) as $line) {
            if (null === $polymerLine) {
                $polymerLine = str_split(trim($line));
                continue;
            }
            if (null === $newLine) {
                $newLine = 1;
                continue;
            }
            [$pair, $element] = explode(' -> ', $line);
            $pairs[$pair] = trim($element);
        }

        //brute forcing the result
        for ($steps = 1; $steps <= 10; $steps++) {
            $count = count($polymerLine);
            $newPolymerLine = [];
            $newPolymerLine[] = $polymerLine[0];

            for ($i = 0; $i < ($count - 1); $i++) {
                $lookForPair = $polymerLine[$i] . $polymerLine[$i + 1];
                $char = $pairs[$lookForPair];
                $newPolymerLine[] = $char;
                $newPolymerLine[] = $polymerLine[$i + 1];
            }

            $polymerLine = $newPolymerLine;
        }

        $counts = array_count_values($polymerLine);

        return max($counts) - min($counts);
    }

    public function secondPart(string $input)
    {
        [$polymerLine, $rulesString] = preg_split("/\R\R/", $input);
        $rules = [];

        foreach (InputGenerator::inputToLineGenerator($rulesString) as $line) {
            [$pair, $element] = explode(' -> ', $line);
            $rules[$pair] = trim($element);
        }

        $pairs = [];

        $counts = array_count_values(str_split($polymerLine));

        $count = strlen($polymerLine);
        for ($i = 0; $i < ($count - 1); $i++) {
            $comb = $polymerLine[$i] . $polymerLine[$i + 1];
            $pairs[$comb] = ($pairs[$comb] ?? 0) + 1;
        }

        $maxSteps = 40;
        while ($maxSteps--) {
            foreach ($pairs as $pair => $count) {
                $char = $rules[$pair];
                $counts[$char] = ($counts[$char] ?? 0) + $count;
                $pairs[$pair] = $pairs[$pair] - $count;

                $comb = $pair[0] . $char;
                $pairs[$comb] = ($pairs[$comb] ?? 0) + $count;

                $comb = $char . $pair[1];
                $pairs[$comb] = ($pairs[$comb] ?? 0) + $count;
            }
        }

        return max($counts) - min($counts);
    }
}
