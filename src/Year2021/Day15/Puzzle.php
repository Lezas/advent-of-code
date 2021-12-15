<?php
declare(strict_types=1);

namespace AdventOfCode\Year2021\Day15;

use AdventOfCode\PuzzleInterface;
use AdventOfCode\Util\InputGenerator;
use SplPriorityQueue;

class Puzzle implements PuzzleInterface
{
    public function firstPart(string $input)
    {
        $grid = [];

        foreach (InputGenerator::inputToLineGenerator($input) as $line) {
            $grid[] = str_split(trim($line));
        }

        $endX = count($grid[0]) - 1;
        $endY = count($grid) - 1;

        $queue = new SplPriorityQueue();
        $queue->insert(['x' => 0, 'y' => 0], 0);
        $queue->setExtractFlags(SplPriorityQueue::EXTR_BOTH);

        $visited = [];
        while (!$queue->isEmpty()) {
            ['data' => $cell, 'priority' => $risk] = $queue->extract();

            $y = $cell['y'];
            $x = $cell['x'];
            $risk = $risk * -1;

            if ($x < 0 || $y < 0) {
                continue;
            }

            if (isset($visited[$y . $x])) {
                continue;
            }
            $visited[$y . $x] = true;

            if ($x === $endX && $y === $endY) {
                return $risk;
            }

            foreach ([[-1, 0], [1, 0], [0, 1], [0, -1],] as [$addX, $addY]) {
                $newX = $x + $addX;
                $newY = $y + $addY;
                if (isset($grid[$newY][$newX])) {
                    //with each cell we calculate total risk up to this point.
                    //we choose path, where cumulative risk is lowest.
                    //next cell will be selected which would have the lowest cumulative risk.

                    //queue prioritizes cells which has the highest priority set.
                    //priority is opposite of risk. Meaning priority should be set for cells which has lower risk.
                    //So risk is inverted, that highest cumulative risk of cell becomes
                    //the lowest number and is last in heap.
                    $queue->insert(['x' => $newX, 'y' => $newY], ($risk + $grid[$newY][$newX]) * -1);
                }
            }
        }

        return '';
    }

    public function secondPart(string $input)
    {
        $grid = [];

        foreach (InputGenerator::inputToLineGenerator($input) as $line) {
            $grid[] = str_split(trim($line));
        }

        $endX = (count($grid[0]) * 5) - 1;
        $endY = (count($grid) * 5) - 1;

        $rowMaxX = count($grid[0]) - 1;
        $rowMaxY = count($grid) - 1;

        $queue = new SplPriorityQueue();
        $queue->insert(['x' => 0, 'y' => 0], 0);
        $queue->setExtractFlags(SplPriorityQueue::EXTR_BOTH);

        $visited = [];
        while (!$queue->isEmpty()) {
            ['data' => $cell, 'priority' => $risk] = $queue->extract();
            $cellY = $cell['y'];
            $cellX = $cell['x'];
            $risk = $risk * -1;
            if (isset($visited[$cellY . $cellX])) {
                continue;
            }
            $visited[$cellY . $cellX] = true;

            if ($cellX === $endX && $cellY === $endY) {
                return $risk;
            }

            if ($cellY > $endY || $cellX > $endX) {
                continue;
            }

            foreach ([[-1, 0], [1, 0], [0, 1], [0, -1],] as [$addX, $addY]) {
                $x = $cellX + $addX;
                $y = $cellY + $addY;

                if ($y > $endY || $x > $endX || $y < 0 || $x < 0) {
                    continue;
                }

                $searchX = $x > $rowMaxX ? $x % ($rowMaxX + 1) : $x;
                $searchY = $y > $rowMaxY ? $y % ($rowMaxY + 1) : $y;

                $multiX = floor($x / ($rowMaxX + 1));
                $multiY = floor($y / ($rowMaxY + 1));

                $nodeRisk = $grid[$searchY][$searchX] + $multiX + $multiY;
                if ($nodeRisk > 9) {
                    $nodeRisk = $nodeRisk % 9;
                    if ($nodeRisk == 0) {
                        $nodeRisk = 9;
                    }
                }

                $queue->insert(['x' => $x, 'y' => $y], ($risk + $nodeRisk) * -1);
            }
        }

        return '';
    }
}
