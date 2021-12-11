<?php

namespace AdventOfCode\Year2021\Day11;

use AdventOfCode\PuzzleInterface;

class Puzzle implements PuzzleInterface
{
    public function firstPart(string $input)
    {
        $lines = explode("\n", trim($input));
        $numbers = [];

        foreach ($lines as $line) {
            $numbers[] = str_split(trim($line));
            //$numbers each line according to your needs
        }

        $sum = 0;

        for ($steps = 1; $steps <= 100; $steps++) {
            $flashed = [];
            foreach ($numbers as $row => &$lines) {
                foreach ($lines as $col => &$octo) {
                    if (!isset($flashed[$row . $col])) {
                        $octo++;
                        if ($octo > 9) {
                            $flashed[$row . $col] = 1;
                            $octo = 0;
                            $this->increaseEnergyForNeighbours($row, $col, $numbers, $flashed);
                        }
                    }
                }
            }
            $stepFlashes = count($flashed);

            $sum += $stepFlashes;
        }

        return $sum;
    }

    public function secondPart(string $input)
    {
        $lines = explode("\n", trim($input));
        $numbers = [];

        foreach ($lines as $line) {
            $numbers[] = str_split(trim($line));
            //$numbers each line according to your needs
        }

        $sum = 0;

        for ($steps = 1; $steps <= 1000; $steps++) {
            $flashed = [];
            foreach ($numbers as $row => &$lines) {
                foreach ($lines as $col => &$octo) {
                    if (!isset($flashed[$row . $col])) {
                        $octo++;
                        if ($octo > 9) {
                            $flashed[$row . $col] = 1;
                            $octo = 0;
                            $this->increaseEnergyForNeighbours($row, $col, $numbers, $flashed);
                        }
                    }
                }
            }
            $stepFlashes = count($flashed);

            if ($stepFlashes === 100) {
                return $steps;
            }

            $sum += $stepFlashes;
        }

        return 'false';
    }

    private function increaseEnergyForNeighbours(int $row, int $col, array &$numbers, array &$flashed)
    {
        $neighbours = [
            'top_left' => [
                'x' => $row - 1,
                'y' => $col - 1,
            ],
            'top' => [
                'x' => $row - 1,
                'y' => $col,
            ],
            'top_right' => [
                'x' => $row - 1,
                'y' => $col + 1,
            ],
            'left' => [
                'x' => $row,
                'y' => $col - 1,
            ],
            'right' => [
                'x' => $row,
                'y' => $col + 1,
            ],
            'bott_left' => [
                'x' => $row + 1,
                'y' => $col - 1,
            ],
            'bott' => [
                'x' => $row + 1,
                'y' => $col,
            ],
            'bott_right' => [
                'x' => $row + 1,
                'y' => $col + 1,
            ],
        ];

        foreach ($neighbours as $neighbour) {
            //top left
            $x = $neighbour['x'];
            $y = $neighbour['y'];

            if (isset($numbers[$x]) && isset($numbers[$x][$y]) && !isset($flashed[$x . $y])) {
                $octo = &$numbers[$x][$y];
                $octo++;
                if ($octo > 9) {
                    $octo = 0;
                    $flashed[$x . $y] = 1;
                    $this->increaseEnergyForNeighbours($x, $y, $numbers, $flashed);
                }
            }
        }
    }

}