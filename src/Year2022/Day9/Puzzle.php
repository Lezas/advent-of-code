<?php

namespace AdventOfCode\Year2022\Day9;

use AdventOfCode\PuzzleInterface;

class Puzzle implements PuzzleInterface
{
    protected const DIRECTIONS = [
        'U' => [
            'y' => +1,
            'x' => 0,
        ],
        'D' => [
            'y' => -1,
            'x' => 0,
        ],
        'L' => [
            'y' => 0,
            'x' => -1,
        ],
        'R' => [
            'y' => 0,
            'x' => 1,
        ],
    ];

    public function firstPart(string $input)
    {
        $lines = explode("\n", trim($input));
        $commands = [];

        foreach ($lines as $line) {
            preg_match('/(?<direction>[A-Z]*) (?<count>[0-9]*)/', trim($line), $matches);
            $commands[] = ['direction' => $matches['direction'], 'count' => $matches['count']];
        }

        $currentHead = ['x' => 1000, 'y' => 1000];
        $currentTail = ['x' => 1000, 'y' => 1000];
        $tailVisited = [];
        $key = 'k' . $currentTail['x'] . $currentTail['y'];
        $tailVisited[$key] += 1;
        foreach ($commands as $command) {
            $direction = $this::DIRECTIONS[$command['direction']];

            for ($i = 1; $i <= $command['count']; $i++) {
                $lastPosition = $currentHead;
                $nextX = $currentHead['x'] + $direction['x'];
                $nextY = $currentHead['y'] + $direction['y'];
                $currentHead['x'] = $nextX;
                $currentHead['y'] = $nextY;

                $xdistance = $currentHead['x'] - $currentTail['x'];
                $ydistance = $currentHead['y'] - $currentTail['y'];
                if (abs($xdistance) > 1 || abs($ydistance) > 1) {
                    $currentTail['x'] = $lastPosition['x'];
                    $currentTail['y'] = $lastPosition['y'];
                    $key = 'k' . $lastPosition['x'] . $lastPosition['y'];
                    $tailVisited[$key] += 1;
                }

            }
        }

        return count($tailVisited);
    }

    public function secondPart(string $input)
    {
        $lines = explode("\n", trim($input));
        $commands = [];

        foreach ($lines as $line) {
            preg_match('/(?<direction>[A-Z]*) (?<count>[0-9]*)/', trim($line), $matches);
            $commands[] = ['direction' => $matches['direction'], 'count' => $matches['count']];
        }
        $hx = $hy = 0;
        $tailVisited = [];

        $knots = \array_fill(0, 9, ['x' => 0, 'y' => 0]);

        foreach ($commands as $command) {
            ['y' => $dY, 'x' => $dX] = $this::DIRECTIONS[$command['direction']];
            for ($i = 0; $i < $command['count']; $i += 1) {
                $hx += $dX;
                $hy += $dY;
                $knots[0] = $this->moveKnot($hx, $hy, $knots[0]['x'], $knots[0]['y']);
                for ($r = 1; $r < 9; $r += 1) {
                    $knots[$r] = $this->moveKnot($knots[$r - 1]['x'], $knots[$r - 1]['y'], $knots[$r]['x'],
                        $knots[$r]['y']);
                }

                $key = 'k' . $knots[8]['x'] . ' ' . $knots[8]['y'];
                $tailVisited[$key] = true;
            }
        }


        return count($tailVisited);
    }

    private function moveKnot(int $hx, int $hy, int $tx, int $ty): array
    {
        $xDiff = \abs($hx - $tx);
        $yDiff = \abs($hy - $ty);
        if ($xDiff >= 2 && $yDiff >= 2) {
            return [
                'x' => $hx - ($hx > $tx ? 1 : -1),
                'y' => $hy - ($hy > $ty ? 1 : -1),
            ];
        }
        if ($xDiff >= 2 && $hy === $ty) {
            return [
                'x' => $hx - ($hx > $tx ? 1 : -1),
                'y' => $ty,
            ];
        }
        if ($xDiff >= 2) {
            return [
                'x' => $hx - ($hx > $tx ? 1 : -1),
                'y' => $hy,
            ];
        }
        if ($yDiff >= 2 && $hx === $tx) {
            return [
                'x' => $tx,
                'y' => $hy - ($hy > $ty ? 1 : -1),
            ];
        }
        if ($yDiff >= 2) {
            return [
                'x' => $hx,
                'y' => $hy - ($hy > $ty ? 1 : -1),
            ];
        }

        return ['x' => $tx, 'y' => $ty];
    }

}
