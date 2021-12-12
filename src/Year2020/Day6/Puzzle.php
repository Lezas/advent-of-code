<?php

namespace AdventOfCode\Year2020\Day6;

use AdventOfCode\PuzzleInterface;

class Puzzle implements PuzzleInterface
{
    public function firstPart(string $input)
    {
        $lines = explode("\n", trim($input));

        $groups = [];

        $group = [];
        foreach ($lines as $line) {
            $line = trim(preg_replace('/\s+/', ' ', $line));
            if (empty($line)){
                $groups[] = $group;
                $group = [];
            } else {
                $group = array_merge($group, str_split($line));
            }
        }

        if (!empty($group)){
            $groups[] = $group;
        }

        $sum = 0;


        foreach ($groups as $group) {
            $chars = array_unique($group);
            $sum += count($chars);
        }

        return $sum;
    }

    public function secondPart(string $input)
    {
        $lines = explode("\n", trim($input));

        $groups = [];

        $group = [];
        foreach ($lines as $line) {
            $line = trim(preg_replace('/\s+/', ' ', $line));
            if (empty($line)){
                $groups[] = $group;
                $group = [];
            } else {
                $group[] = str_split($line);
            }
        }

        if (!empty($group)){
            $groups[] = $group;
        }

        $sum = 0;

        foreach ($groups as $group) {
            $allYes = array_shift($group);

            foreach ($group as $personChars) {
                $allYes = array_intersect($allYes, $personChars);
            }

            $sum += count($allYes);
        }

        return $sum;
    }
}