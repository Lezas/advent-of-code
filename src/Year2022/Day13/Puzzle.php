<?php

namespace AdventOfCode\Year2022\Day13;

use AdventOfCode\PuzzleInterface;

class Puzzle implements PuzzleInterface
{
    public function firstPart(string $input)
    {
        $pairs = explode("\n\n", trim($input));

        $count = 0;
        $sum = 0;
        foreach ($pairs as $pair) {
            $count++;
            [$pair1String, $pair2String] = explode("\n", trim($pair));
            $pair1 = eval('return ' . $pair1String . ';');
            $pair2 = eval('return ' . $pair2String . ';');

            $result = $this->compare($pair1, $pair2);
            if ($result === true) {
                $sum += $count;
            }
        }

        return $sum;
    }

    public function compare($pair1, $pair2): ?bool
    {
        if ($pair1 !== null && $pair2 === null) {
            return false;
        }
        if ($pair1 === null && $pair2 !== null) {
            return true;
        }

        if (is_array($pair1) && !is_array($pair2)) {
            $pair2 = [$pair2];

            return $this->compare($pair1, $pair2);
        }
        if (!is_array($pair1) && is_array($pair2)) {
            $pair1 = [$pair1];

            return $this->compare($pair1, $pair2);
        }

        if (is_int($pair1) && is_int($pair2)) {
            if ($pair1 == $pair2) {
                return null;
            }
            if ($pair1 < $pair2) {
                return true;
            } else {
                return false;
            }
        }

        $max = max(count($pair1), count($pair2));

        for ($i = 0; $i < $max; $i++) {
            $result = $this->compare($pair1[$i], $pair2[$i]);

            if ($result !== null) {
                return $result;
            }
        }

        return null;
    }

    public function secondPart(string $input)
    {
        $pairs = explode("\n\n", trim($input));

        $packets = [];
        foreach ($pairs as $pair) {
            [$pair1String, $pair2String] = explode("\n", trim($pair));
            $packets[] = eval('return ' . $pair1String . ';');
            $packets[] = eval('return ' . $pair2String . ';');
        }

        $packets[] = eval('return ' . '[[2]]' . ';');
        $packets[] = eval('return ' . '[[6]]' . ';');

        $pair2Key = array_key_last($packets);
        $pair1Key = $pair2Key - 1;

        uasort($packets, function ($a, $b) {
            $result = $this->compare($a, $b);
            if ($result === true) {
                return -1;
            }
            if ($result === false) {
                return 1;
            }

            return 0;
        });

        return (array_search($pair1Key, array_keys($packets)) +1) * (array_search($pair2Key, array_keys($packets)) +1);

    }
}
