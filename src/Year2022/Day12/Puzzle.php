<?php

namespace AdventOfCode\Year2022\Day12;

use AdventOfCode\PuzzleInterface;
use SplPriorityQueue;

class Puzzle implements PuzzleInterface
{
    public function firstPart(string $input)
    {
        $lines = explode("\n", trim($input));
        $grid = [];

        foreach ($lines as $line) {
            $grid[] = str_split(trim($line));
        }

        $startLetter = 'S';
        $finishLetter = 'E';

        foreach ($grid as $rowKey => $row) {
            foreach ($row as $columnKey => $column) {
                if ($column == $finishLetter) {
                    $endY = $rowKey;
                    $endX = $columnKey;
                }
                if ($column == $startLetter) {
                    $startY = $rowKey;
                    $startX = $columnKey;
                }
            }
        }

        $queue = new SplPriorityQueue();
        $queue->insert([
            'x'    => $startX,
            'y'    => $startY,
            'path' => [$startX . ' ' . $startY => ['x' => $startX, 'y' => $startY]],
        ], 0);
        $queue->setExtractFlags(SplPriorityQueue::EXTR_BOTH);

        $visited = [];
        while (!$queue->isEmpty()) {
            $extract = $queue->extract();
            ['data' => $cell, 'priority' => $risk] = $extract;

            $y = $cell['y'];
            $x = $cell['x'];
            $risk = $risk * -1;

            if ($x < 0 || $y < 0) {
                continue;
            }

            if (isset($visited[$y . ' ' . $x])) {
                continue;
            }
            $visited[$y . ' ' . $x] = $y . $x;

            if ($x == $endX && $y == $endY) {
                $winner = $extract;
                break;
            }

            foreach ([[-1, 0], [1, 0], [0, -1], [0, 1],] as [$addX, $addY]) {
                $newX = $x + $addX;
                $newY = $y + $addY;
                if (isset($grid[$newY][$newX])) {

                    $currentCellValue = $grid[$y][$x];
                    $nextCellValue = $grid[$newY][$newX];

                    if ($currentCellValue == 'S') {
                        $currentCellValue = 'a';
                    }
                    if ($nextCellValue == 'E') {
                        $nextCellValue = 'z';
                    }

                    $currentCellValue = ord($currentCellValue);
                    $nextCellValue = ord($nextCellValue);

                    if ($nextCellValue - $currentCellValue > 1) {
                        continue;
                    }

                    $path = $cell['path'];
                    $path[$newX . ' ' . $newY] = ['x' => $newX, 'y' => $newY];
                    $queue->insert(['x' => $newX, 'y' => $newY, 'path' => $path], ($risk + 1) * -1);
                }
            }
        }

        $this->echoWinnerAnimation($grid, $winner, $winner['data']['path']);

        return $winner['priority'] * -1;
    }

    public function secondPart(string $input)
    {
        $lines = explode("\n", trim($input));
        $grid = [];

        foreach ($lines as $line) {
            $grid[] = str_split(trim($line));
        }

        $startLetter = 'E';
        $finishLetter = 'a';

        foreach ($grid as $rowKey => $row) {
            foreach ($row as $columnKey => $column) {
                if ($column == $startLetter) {
                    $startY = $rowKey;
                    $startX = $columnKey;
                }
            }
        }

        $queue = new SplPriorityQueue();
        $queue->insert([
            'x'       => $startX,
            'y'       => $startY,
            'path'    => [$startX . ' ' . $startY => ['x' => $startX, 'y' => $startY]],
            'visited' => [
                $startY . ' ' . $startX => true,
            ],
        ], 0);
        $queue->setExtractFlags(SplPriorityQueue::EXTR_BOTH);

        $visited = [];

        while (!$queue->isEmpty()) {
            $extract = $queue->extract();
            ['data' => $cell, 'priority' => $risk] = $extract;

            $y = $cell['y'];
            $x = $cell['x'];
            $risk = $risk * -1;

            if ($x < 0 || $y < 0) {
                continue;
            }

            if (isset($visited[$y . ' ' . $x])) {
                continue;
            }
            $visited[$y . ' ' . $x] = $y . $x;

            if ($grid[$y][$x] == $finishLetter) {
                $winner = $extract;
                break;
            }

            foreach ([[-1, 0], [1, 0], [0, -1], [0, 1],] as [$addX, $addY]) {
                $newX = $x + $addX;
                $newY = $y + $addY;
                if (isset($visited[$newY . ' ' . $newX])) {
                    continue;
                }
                if (isset($grid[$newY][$newX])) {
                    $currentCellValue = $grid[$y][$x];
                    $nextCellValue = $grid[$newY][$newX];


                    if ($currentCellValue == 'E') {
                        $currentCellValue = 'z';
                    }
                    if ($nextCellValue == 'S') {
                        $nextCellValue = 'a';
                    }

                    $currentCellValue = ord($currentCellValue);
                    $nextCellValue = ord($nextCellValue);

                    if ($nextCellValue - $currentCellValue < -1) {
                        continue;
                    }

                    $path = $cell['path'];
                    $path[$newX . ' ' . $newY] = ['x' => $newX, 'y' => $newY];

                    $queue->insert(['x' => $newX, 'y' => $newY, 'path' => $path], ($risk + 1) * -1);
                }
            }
        }

        $this->echoWinnerAnimation($grid, $winner, $winner['data']['path']);

        return $winner['priority'] * -1;
    }

    public function echoWinnerAnimation(array $grid, array $winner, array $paths)
    {
        system('clear');
        foreach ($grid as $rowKey => $row) {
            foreach ($row as $columnKey => $column) {
                    $value = ord($column) - 96;
                    if ($value == 3) {
                        echo $this->getColor(86, $column);
                    } else if ($value == 2) {
                        echo $this->getColor(64, $column);
                    }
                    else if ($value < 4) {
                        echo $this->getColor(215, $column);
                    } else if ($value < 6) {
                        echo $this->getColor(216, $column);
                    } else if ($value < 8) {
                        echo $this->getColor(217, $column);
                    } else if ($value < 10) {
                        echo $this->getColor(218, $column);
                    } else if ($value < 12) {
                        echo $this->getColor(219, $column);
                    } else if ($value < 14) {
                        echo $this->getColor(222, $column);
                    } else if ($value < 17) {
                        echo $this->getColor(221, $column);
                    } else if ($value < 20) {
                        echo $this->getColor(222, $column);
                    } else if ($value < 22) {
                        echo $this->getColor(223, $column);
                    } else if ($value < 24) {
                        echo $this->getColor(224, $column);
                    } else if ($value < 27) {
                        echo $this->getColor(225, $column);
                    }
            }
            echo PHP_EOL;
        }

        foreach ($paths as $cell) {
            $x = $cell['x'] + 2;
            $y = $cell['y'] +1;
            $column = $grid[$y -1][$x - 2];
            echo "\033[$y;{$x}f"; //position curson
            echo chr(8); //remove back char
            echo $this->getColor(226, $column);
            usleep(40000);
        }
        $maxx = count($grid[0]);
        $maxy = count($grid);
        echo "\033[$maxy;{$maxx}f";
        echo "\n";
    }

    private function getColor(int $code, $value)
    {
        return "\033[38;5;{$code}m\033[48;5;{$code}m$value";
    }
}
