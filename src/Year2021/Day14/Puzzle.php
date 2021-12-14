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
        sort($counts);

        $last = array_pop($counts);
        $least = array_shift($counts);

        return $last - $least;
    }

    public function secondPart(string $input)
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

        $counts = [];
        $multipliers = [];

        foreach ($polymerLine as $item) {
            if (!isset($counts[$item])) {
                $counts[$item] = 1;
            } else {
                $counts[$item] += 1;
            }
        }

        $count = count($polymerLine);
        for ($i = 0; $i < ($count - 1); $i++) {
            $charOne = $polymerLine[$i];
            $charTwo = $polymerLine[$i + 1];
            $comb = $charOne . $charTwo;
            if (!isset($multipliers[$comb])) {
                $multipliers[$comb] = [
                    'multi' => 1,
                    'char1' => $charOne,
                    'char2' => $charTwo,
                ];
            } else {
                $multipliers[$comb]['multi'] += 1;
            }
        }

        $maxSteps = 40;
        for ($step = 1; $step <= $maxSteps; $step++) {
            $copy = $multipliers;
            foreach ($copy as $multiplierChar => $settings) {
                $char = $pairs[$multiplierChar];

                if (!isset($counts[$char])) {
                    $counts[$char] = $settings['multi'];
                } else {
                    $counts[$char] += $settings['multi'];
                }

                $comb = $settings['char1'] . $char;
                if (!isset($multipliers[$comb])) {
                    $multipliers[$comb] = [
                        'multi' => $settings['multi'],
                        'char1' => $settings['char1'],
                        'char2' => $char,
                    ];
                } else {
                    $multipliers[$comb]['multi'] += $settings['multi'];
                }

                $comb =  $char . $settings['char2'];
                if (!isset($multipliers[$comb])) {
                    $multipliers[$comb] = [
                        'multi' => $settings['multi'],
                        'char1' => $char,
                        'char2' => $settings['char2'],
                    ];
                } else {
                    $multipliers[$comb]['multi'] += $settings['multi'];
                }

                $multipliers[$multiplierChar]['multi'] -= $settings['multi'];
            }
        }

        sort($counts);

        $last = array_pop($counts);
        $least = array_shift($counts);

        return $last - $least;
    }
}
