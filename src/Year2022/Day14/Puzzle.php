<?php

namespace AdventOfCode\Year2022\Day14;

use AdventOfCode\PuzzleInterface;

class Puzzle implements PuzzleInterface
{
    public function firstPart(string $input)
    {
        $stringLines = explode("\n", trim($input));

        $grid = [];

        $maxY = 0;
        foreach ($stringLines as $line) {
            $walls = explode(' -> ', $line);
            $count = count($walls);
            $start = explode(',', $walls[0]);

            for ($i = 1; $i < $count; $i++) {
                $end = explode(',', $walls[$i]);

                $xDiff = range($start[0], $end[0]);
                $yDiff = range($start[1], $end[1]);

                foreach ($xDiff as $x) {
                    foreach ($yDiff as $y) {
                        if ($y > $maxY) {
                            $maxY = $y;
                        }
                        $grid[$y][$x] = 1;
                    }
                }
                $start = $end;
            }
        }


        $grain = [
            'x' => 500,
            'y' => 1,
        ];
        $sand = 0;
        while (1) {
            foreach ([[1, 0], [1, -1], [1, +1],] as [$yAdvance, $xAdvance]) {
                if (!isset($grid[$grain['y'] + $yAdvance][$grain['x'] + $xAdvance])) {
                    $grid[$grain['y'] + $yAdvance][$grain['x'] + $xAdvance] = 0;
                }
            }

            if ($maxY < $grain['y']) {
                break;
            }
            if ($grid[$grain['y'] + 1][$grain['x']] === 0) {
                $grain['y']++;
                continue;
            } elseif ($grid[$grain['y'] + 1][$grain['x'] - 1] === 0) {
                $grain['y']++;
                $grain['x']--;
                continue;
            } elseif ($grid[$grain['y'] + 1][$grain['x'] + 1] === 0) {
                $grain['y']++;
                $grain['x']++;
                continue;
            } else {
                $sand++;
                $grid[$grain['y']][$grain['x']] = 3;
                $grain = [
                    'x' => 500,
                    'y' => 1,
                ];
            }
        }

        return $sand;
    }

    public function secondPart(string $input)
    {
        $stringLines = explode("\n", trim($input));

        $grid = [];

        $maxY = 0;
        foreach ($stringLines as $line) {
            $walls = explode(' -> ', $line);
            $count = count($walls);
            $start = explode(',', $walls[0]);

            for ($i = 1; $i < $count; $i++) {
                $end = explode(',', $walls[$i]);

                $xDiff = range($start[0], $end[0]);
                $yDiff = range($start[1], $end[1]);

                foreach ($xDiff as $x) {
                    foreach ($yDiff as $y) {
                        if ($y > $maxY) {
                            $maxY = $y;
                        }
                        $grid[$y][$x] = 1;
                    }
                }
                $start = $end;
            }
        }

        $groundY = $maxY + 2;

        $grain = [
            'x' => 500,
            'y' => 0,
        ];
        $sand = 0;
        while (1) {
            foreach ([[1, 0], [1, -1], [1, +1],] as [$yAdvance, $xAdvance]) {
                if (!isset($grid[$grain['y'] + $yAdvance][$grain['x'] + $xAdvance])) {
                    $grid[$grain['y'] + $yAdvance][$grain['x'] + $xAdvance] = 0;
                    if ($groundY === $grain['y'] + $yAdvance) {
                        $grid[$grain['y'] + $yAdvance][$grain['x'] + $xAdvance] = 1;
                    }
                }
            }
            if ($grid[$grain['y'] + 1][$grain['x']] == 0) {
                $grain['y']++;
                continue;
            } elseif ($grid[$grain['y'] + 1][$grain['x'] - 1] == 0) {
                $grain['y']++;
                $grain['x']--;
                continue;
            } elseif ($grid[$grain['y'] + 1][$grain['x'] + 1] == 0) {
                $grain['y']++;
                $grain['x']++;
                continue;
            } else {
                $sand++;
                $grid[$grain['y']][$grain['x']] = 3;

                if ($grain['x'] == 500 && $grain['y'] == 0) {
                    break;
                }
                $grain = [
                    'x' => 500,
                    'y' => 0,
                ];
            }
        }

        return $sand;
    }
}
