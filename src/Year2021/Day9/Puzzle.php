<?php

namespace AdventOfCode\Year2021\Day9;

use AdventOfCode\PuzzleInterface;

class Puzzle implements PuzzleInterface
{
    public function firstPart(string $input)
    {
        $lines = explode("\n", trim($input));
        $map = [];

        foreach ($lines as $line) {
            $map[] = trim($line);
        }

        $maxLines = count($map) - 1;

        $sum = 0;

        for ($i = 0; $i <= $maxLines; $i++) {
            $row = $map[$i];
            $lenghtOfRow = strlen($row) - 1;
            $numbers = str_split($row);

            for ($numberI = 0; $numberI <= $lenghtOfRow; $numberI++) {
                $currentHeight = $numbers[$numberI];

                $top = null;
                if (isset($map[$i - 1][$numberI])) {
                    $top = $map[$i - 1][$numberI];
                }

                $left = null;
                if (isset($map[$i][$numberI - 1])) {
                    $left = $map[$i][$numberI - 1];
                }

                $right = null;
                if (isset($map[$i][$numberI + 1])) {
                    $right = $map[$i][$numberI + 1];
                }

                $bottom = null;
                if (isset($map[$i + 1][$numberI])) {
                    $bottom = $map[$i + 1][$numberI];
                }

                if (
                    ($top === null || $top > $currentHeight)
                    && ($left === null || $left > $currentHeight)
                    && ($right === null || $right > $currentHeight)
                    && ($bottom === null || $bottom > $currentHeight)
                ) {
                    $riskLevel = 1 + $currentHeight;
                    $sum += $riskLevel;
                }
            }
        }

        return $sum;

    }

    public function secondPart(string $input)
    {
        $lines = explode("\n", trim($input));
        $map = [];

        foreach ($lines as $line) {
            $map[] = str_split(trim($line));
        }

        $maxLines = count($map) - 1;

        $basins = [];

        for ($i = 0; $i <= $maxLines; $i++) {
            $row = $map[$i];
            $lenghtOfRow = count($row) - 1;
            $numbers = $row;

            for ($numberI = 0; $numberI <= $lenghtOfRow; $numberI++) {
                $currentHeight = $numbers[$numberI];

                $top = null;
                if (isset($map[$i - 1][$numberI])) {
                    $top = $map[$i - 1][$numberI];
                }

                $left = null;
                if (isset($map[$i][$numberI - 1])) {
                    $left = $map[$i][$numberI - 1];
                }

                $right = null;
                if (isset($map[$i][$numberI + 1])) {
                    $right = $map[$i][$numberI + 1];
                }

                $bottom = null;
                if (isset($map[$i + 1][$numberI])) {
                    $bottom = $map[$i + 1][$numberI];
                }

                if (
                    ($top === null || $top > $currentHeight)
                    && ($left === null || $left > $currentHeight)
                    && ($right === null || $right > $currentHeight)
                    && ($bottom === null || $bottom > $currentHeight)
                ) {
                    $result = $this->getBasin($map, $i, $numberI);

                    $basins[$result['sumOfCells']] = $result['countOfCells'];
                }
            }
        }

        rsort($basins);
        $top3 = array_slice($basins, 0, 3);

        $multiply = 1;

        foreach ($top3 as $item) {
            $multiply *= $item;
        }

        return $multiply;
    }

    private function getNeighbours(array $map, int $y, int $x, array &$visited)
    {
        if (isset($map[$y - 1][$x]) && $map[$y - 1][$x] < 9) {
            $key = ($y - 1) . ($x);
            if (!isset($visited[$key])) {
                $visited[$key] = [
                    'value' => $map[$y - 1][$x],
                    'x' => $x,
                    'y' => $y - 1,
                ];
                $this->getNeighbours($map, $y - 1, $x, $visited);
            }
        }
        if (isset($map[$y + 1][$x]) && $map[$y + 1][$x] < 9) {
            $key = ($y + 1) . ($x);
            if (!isset($visited[$key])) {
                $visited[$key] = [
                    'value' => $map[$y + 1][$x],
                    'x' => $x,
                    'y' => $y - 1,
                ];
                $this->getNeighbours($map, $y + 1, $x, $visited);
            }
        }
        if (isset($map[$y][$x - 1]) && $map[$y][$x - 1] < 9) {
            $key = ($y) . ($x - 1);
            if (!isset($visited[$key])) {
                $visited[$key] = [
                    'value' => $map[$y][$x - 1],
                    'x' => $x - 1,
                    'y' => $y,
                ];
                $this->getNeighbours($map, $y, $x - 1, $visited);
            }
        }
        if (isset($map[$y][$x + 1]) && $map[$y][$x + 1] < 9) {
            $key = ($y) . ($x + 1);
            if (!isset($visited[$key])) {
                $visited[$key] =
                    [
                        'value' => $map[$y][$x + 1],
                        'x' => $x + 1,
                        'y' => $y,
                    ];
                $this->getNeighbours($map, $y, $x + 1, $visited);
            }
        }
    }

    private function getBasin(array $map, int $y, int $x): ?array
    {
        $visited = [];
        $visited[$y . $x] =
            [
                'value' => $map[$y][$x],
                'x' => $x,
                'y' => $y,
            ];

        $sum = 0;

        $this->getNeighbours($map, $y, $x, $visited);

        foreach ($visited as $item) {
            $sum += (int)$item['value'];
        }

        return [
            'countOfCells' => count($visited),
            'sumOfCells' => $sum,
        ];
    }
}