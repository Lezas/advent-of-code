<?php

namespace AdventOfCode\Year2022\Day8;

use AdventOfCode\PuzzleInterface;

class Puzzle implements PuzzleInterface
{
    protected const DIRECTIONS = [
        'up'    => [
            'line'   => -1,
            'column' => 0,
        ],
        'down'  => [
            'line'   => +1,
            'column' => 0,
        ],
        'left'  => [
            'line'   => 0,
            'column' => -1,
        ],
        'right' => [
            'line'   => 0,
            'column' => 1,
        ],
    ];

    public function firstPart(string $input)
    {
        $lines = explode("\n", trim($input));
        $map = [];

        foreach ($lines as $line) {
            $map[] = str_split(trim($line));
        }

        $maxLinesKey = count($map) - 1;
        $maxColumnsKey = count($map[0]) - 1;

        $visibleTrees = [];
        foreach ($map as $lineKey => $lines) {
            foreach ($lines as $columnKey => $cell) {
                //detect if on border
                if ($lineKey == 0 || $lineKey == $maxLinesKey || $columnKey == 0 || $columnKey == $maxColumnsKey) {
                    $visibleTrees[$lineKey][$columnKey] = $cell;
                    continue;
                }

                $treeHeight = $cell;

                foreach ($this::DIRECTIONS as $direction) {
                    $currentLineKey = $lineKey;
                    $currentColumnKey = $columnKey;

                    $currentLineKey += $direction['line'];
                    $currentColumnKey += $direction['column'];

                    while (isset($map[$currentLineKey][$currentColumnKey])) {
                        if ($map[$currentLineKey][$currentColumnKey] >= $treeHeight) {
                            continue 2;
                        }
                        $currentLineKey += $direction['line'];
                        $currentColumnKey += $direction['column'];
                    }
                    $visibleTrees[$lineKey][$columnKey] = $cell;
                }
            }
        }

        $count = 0;
        array_walk_recursive($visibleTrees, function ($item) use (&$count) {
            $count++;
        });

        return $count;
    }

    public function secondPart(string $input)
    {
        $lines = explode("\n", trim($input));
        $map = [];

        foreach ($lines as $line) {
            $map[] = str_split(trim($line));
        }

        $scores = [];

        foreach ($map as $lineKey => $lines) {
            foreach ($lines as $columnKey => $cell) {
                $score = 1;
                $treeHeight = $cell;

                foreach ($this::DIRECTIONS as $direction) {
                    $directionScore = 0;
                    $currentLineKey = $lineKey;
                    $currentColumnKey = $columnKey;

                    $currentLineKey += $direction['line'];
                    $currentColumnKey += $direction['column'];

                    while (isset($map[$currentLineKey][$currentColumnKey])) {
                        $directionScore++;
                        if ($map[$currentLineKey][$currentColumnKey] >= $treeHeight) {
                            break;
                        }
                        $currentLineKey += $direction['line'];
                        $currentColumnKey += $direction['column'];
                    }
                    $score *= $directionScore;
                }

                $scores[$lineKey][$columnKey] = $score;
            }
        }

        $max = 0;
        array_walk_recursive($scores, function ($item) use (&$max) {
            if ($item > $max) {
                $max = $item;
            }
        });

        return $max;
    }
}
