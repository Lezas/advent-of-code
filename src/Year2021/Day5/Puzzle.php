<?php

namespace AdventOfCode\Year2021\Day5;

use AdventOfCode\PuzzleInterface;

class Puzzle implements PuzzleInterface
{
    public function firstPart(string $input)
    {
        $lines = explode("\n", trim($input));

        $coordinates = [];
        $cells = [];

        foreach ($lines as $line) {
            preg_match(
                '/(?<firstY>[0-9]+),(?<firstX>[0-9]+) -> +(?<secondY>[0-9]+),(?<secondX>[0-9]+)/',
                $line,
                $matches
            );

            $coordinates[] = $matches;
        }

        foreach ($coordinates as $coordinate) {
            if ($coordinate['firstY'] !== $coordinate['secondY'] && $coordinate['firstX'] !== $coordinate['secondX']) {
                continue;
            }

            if ($coordinate['firstY'] === $coordinate['secondY']) {
                $y = (int)$coordinate['firstY'];
                $fromX = (int)$coordinate['firstX'];
                $secondX = (int)$coordinate['secondX'];

                if ($fromX > $secondX) {
                    $tmp = $fromX;
                    $fromX = $secondX;
                    $secondX = $tmp;
                }

                for ($i = $fromX; $i <= $secondX; $i++) {
                    $key = $y . $i;
                    if (!isset($cells[$y][$i])) {
                        $cells[$y][$i] = 1;
                    } else {
                        $cells[$y][$i]++;
                    }
                }

                continue;
            }

            if ($coordinate['firstX'] === $coordinate['secondX']) {
                $x = (int)$coordinate['firstX'];
                $fromY = (int)$coordinate['firstY'];
                $secondY = (int)$coordinate['secondY'];

                if ($fromY > $secondY) {
                    $tmp = $fromY;
                    $fromY = $secondY;
                    $secondY = $tmp;
                }

                for ($i = $fromY; $i <= $secondY; $i++) {
                    $key = $i . $x;
                    if (!isset($cells[$i][$x])) {
                        $cells[$i][$x] = 1;
                    } else {
                        $cells[$i][$x]++;
                    }
                }

                continue;
            }
        }

        $sum = 0;

        foreach ($cells as $cell) {
            foreach ($cell as $item) {
                if ($item > 1) {
                    $sum++;
                }
            }
        }

        return $sum;
    }

    public function secondPart(string $input)
    {
        $lines = explode("\n", trim($input));

        $coordinates = [];
        $cells = [];

        foreach ($lines as $line) {
            preg_match(
                '/(?<firstY>[0-9]+),(?<firstX>[0-9]+) -> +(?<secondY>[0-9]+),(?<secondX>[0-9]+)/',
                $line,
                $matches
            );

            $coordinates[] = $matches;
        }

        foreach ($coordinates as $coordinate) {
            //detect diagonal line

            $differenceY = $coordinate['firstY'] - $coordinate['secondY'];
            $differenceX = $coordinate['firstX'] - $coordinate['secondX'];

            $adjustedDifferenceY = $differenceY;
            if ($differenceY < 0) {
                $adjustedDifferenceY  *= -1;
            }

            $adjustedDifferenceX = $differenceX;
            if ($differenceX < 0) {
                $adjustedDifferenceX *= -1;
            }

            if ($adjustedDifferenceY === $adjustedDifferenceX) {
                for ($loopCount = 0; $loopCount <= $adjustedDifferenceY; $loopCount++) {


                    if ($differenceY < 0) {
                        $y = $coordinate['firstY'] + $loopCount;
                    } else {
                        $y = $coordinate['firstY'] - $loopCount;
                    }
                    if ($differenceX < 0) {
                        $x = $coordinate['firstX'] + $loopCount;
                    } else {
                        $x = $coordinate['firstX'] - $loopCount;
                    }

                    if (!isset($cells[$y][$x])) {
                        $cells[$y][$x] = 1;
                    } else {
                        $cells[$y][$x]++;
                    }
                }

                continue;
            }


            //if not diagonal - leave as is.
            if ($coordinate['firstY'] !== $coordinate['secondY'] && $coordinate['firstX'] !== $coordinate['secondX']) {
                continue;
            }

            if ($coordinate['firstY'] === $coordinate['secondY']) {
                $y = (int)$coordinate['firstY'];
                $fromX = (int)$coordinate['firstX'];
                $secondX = (int)$coordinate['secondX'];

                if ($fromX > $secondX) {
                    $tmp = $fromX;
                    $fromX = $secondX;
                    $secondX = $tmp;
                }

                for ($i = $fromX; $i <= $secondX; $i++) {
                    $key = $y . $i;
                    if (!isset($cells[$y][$i])) {
                        $cells[$y][$i] = 1;
                    } else {
                        $cells[$y][$i]++;
                    }
                }

                continue;
            }

            if ($coordinate['firstX'] === $coordinate['secondX']) {
                $x = (int)$coordinate['firstX'];
                $fromY = (int)$coordinate['firstY'];
                $secondY = (int)$coordinate['secondY'];

                if ($fromY > $secondY) {
                    $tmp = $fromY;
                    $fromY = $secondY;
                    $secondY = $tmp;
                }

                for ($i = $fromY; $i <= $secondY; $i++) {
                    $key = $i . $x;
                    if (!isset($cells[$i][$x])) {
                        $cells[$i][$x] = 1;
                    } else {
                        $cells[$i][$x]++;
                    }
                }

                continue;
            }
        }

        $sum = 0;

        foreach ($cells as $cell) {
            foreach ($cell as $item) {
                if ($item > 1) {
                    $sum++;
                }
            }
        }

        var_dump($sum);

        return $sum;
    }
}
