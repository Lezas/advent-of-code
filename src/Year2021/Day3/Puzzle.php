<?php

namespace AdventOfCode\Year2021\Day3;

use AdventOfCode\PuzzleInterface;
use AdventOfCode\Util\InputGenerator;

class Puzzle implements PuzzleInterface
{
    public function firstPart(string $input)
    {
        $map = [];

        foreach (InputGenerator::inputToLineGenerator($input) as $key => $line) {
            foreach (str_split(trim($line)) as $x => $number) {
                $map[$x][$key] = $number;
            }
        }

        $gama = '';
        $epsilon = '';
        foreach ($map as $bits) {
            $counts = array_count_values($bits);
            if ($counts[0] > $counts[1]) {
                $gama .= 0;
                $epsilon .= 1;
            } else {
                $gama .= 1;
                $epsilon .= 0;
            }
        }

        return bindec($gama) * bindec($epsilon);
    }

    public function secondPart(string $input)
    {
        $map = [];

        foreach (InputGenerator::inputToLineGenerator($input) as $key => $line) {
            foreach (str_split(trim($line)) as $x => $number) {
                $map[$x][$key] = $number;
            }
        }

        $gama = '';
        $epsilon = '';
        $keysToIgnoreEpsilon = [];
        $keysToIgnoreGama = [];
        foreach ($map as $bits) {
            $count = count(array_diff_key($bits, array_flip($keysToIgnoreGama)));
            $counts = array_count_values(array_diff_key($bits, array_flip($keysToIgnoreGama)));
            if ($count == 1) {
                $arr = array_diff_key($bits, array_flip($keysToIgnoreGama));
                $gama .= reset($arr);
                break;
            } elseif ($counts[0] > $counts[1]) {
                $gama .= 0;
                $keysToRemove = array_keys(array_diff_key($bits, array_flip($keysToIgnoreGama)), 1);
                $keysToIgnoreGama = array_merge($keysToIgnoreGama, $keysToRemove);
            } elseif ($counts[0] < $counts[1]) {
                $gama .= 1;
                $keysToRemove = array_keys(array_diff_key($bits, array_flip($keysToIgnoreGama)), 0);
                $keysToIgnoreGama = array_merge($keysToIgnoreGama, $keysToRemove);
            } else {
                $gama .= 1;
                $keysToRemove = array_keys(array_diff_key($bits, array_flip($keysToIgnoreGama)), 0);
                $keysToIgnoreGama = array_merge($keysToIgnoreGama, $keysToRemove);
            }
            $count = count(array_diff_key($bits, array_flip($keysToIgnoreEpsilon)));
            $counts = array_count_values(array_diff_key($bits, array_flip($keysToIgnoreEpsilon)));
            if ($count == 1) {
                $arr = array_diff_key($bits, array_flip($keysToIgnoreEpsilon));
                $epsilon .= reset($arr);
            } elseif ($counts[0] < $counts[1]) {
                $epsilon .= 0;
                $keysToRemove = array_keys(array_diff_key($bits, array_flip($keysToIgnoreEpsilon)), 1);
                $keysToIgnoreEpsilon = array_merge($keysToIgnoreEpsilon, $keysToRemove);
            } elseif ($counts[0] > $counts[1]) {
                $epsilon .= 1;
                $keysToRemove = array_keys(array_diff_key($bits, array_flip($keysToIgnoreEpsilon)), 0);
                $keysToIgnoreEpsilon = array_merge($keysToIgnoreEpsilon, $keysToRemove);
            } else {
                $epsilon .= 0;
                $keysToRemove = array_keys(array_diff_key($bits, array_flip($keysToIgnoreEpsilon)), 1);
                $keysToIgnoreEpsilon = array_merge($keysToIgnoreEpsilon, $keysToRemove);
            }
        }

        return bindec($gama) * bindec($epsilon);
    }
}
