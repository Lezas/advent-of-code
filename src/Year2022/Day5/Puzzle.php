<?php

namespace AdventOfCode\Year2022\Day5;

use AdventOfCode\PuzzleInterface;

class Puzzle implements PuzzleInterface
{
    public function firstPart(string $input)
    {
        $crates = [
            1 => ['N', 'H', 'S', 'J', 'F', 'W', 'T', 'D'],
            2 => ['G', 'B', 'N', 'T', 'Q', 'P', 'R', 'H'],
            3 => ['V', 'Q', 'L'],
            4 => ['Q', 'R', 'W', 'S', 'B', 'N'],
            5 => ['B', 'M', 'V', 'T', 'F', 'D', 'N'],
            6 => ['R', 'T', 'H', 'V', 'B', 'D', 'M'],
            7 => ['J', 'Q', 'B', 'D'],
            8 => ['Q', 'H', 'Z', 'R', 'V', 'J', 'N', 'D'],
            9 => ['S', 'M', 'H', 'N', 'B'],
        ];
//        $crates = [
//            1 => ['N', 'Z'],
//            2 => ['D', 'C', 'M'],
//            3 => ['P'],
//        ];
        foreach ($crates as $key => $crate) {
            $crates[$key] = array_reverse($crate);
        }
        $lines = explode("\n", trim($input));

        foreach ($lines as $line) {
            preg_match('/move (?<count>[0-9]*) from (?<fromPosition>[0-9]*) to (?<toPosition>[0-9]*)/', $line, $matches);
            $instructions = [
                'count'        => $matches['count'],
                'fromPosition' => $matches['fromPosition'],
                'toPosition'   => $matches['toPosition'],
            ];
            var_dump($instructions);

            $tmpCrates = [];

            for ($i = 1; $i<= $instructions['count']; $i++) {
                $tmpCrates[] = array_pop($crates[$instructions['fromPosition']]);

            }

            $tmpCrates = array_reverse($tmpCrates);
            foreach ($tmpCrates as $tmpCrate) {
                $crates[$instructions['toPosition']][] = $tmpCrate;
            }


            foreach ($crates as $crate) {
                echo implode('', $crate) . PHP_EOL;
            }
        }

//        var_dump($crates);
//        exit;
        $string = '';
        foreach ($crates as $crate) {
            $string .= array_pop($crate);
        }

        return $string;
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
