<?php

namespace AdventOfCode\Year2021\Day13;

use AdventOfCode\PuzzleInterface;
use AdventOfCode\Util\InputGenerator;

class Puzzle implements PuzzleInterface
{
    public function firstPart(string $input)
    {
        $map = [];
        $foldInstructions = [];

        $mode = 0;

        foreach (InputGenerator::inputToLineGenerator($input) as $line) {
            $line = trim($line);
            if (empty($line)) {
                $mode = 1;
                continue;
            }

            if ($mode === 0) {
                [$x, $y] = explode(',', $line);
                $map[$y][$x] = 1;
            } else {
                preg_match('/fold along (?<dimension>[a-z])=(?<value>[0-9]+)/', $line, $matches);
                $foldInstructions[] = [
                    'dimension' => $matches['dimension'],
                    'value'     => $matches['value'],
                ];
            }
        }

        $firstFold = array_shift($foldInstructions);
        $this->fold($map, $firstFold['dimension'], $firstFold['value']);

        $sum = 0;
        foreach ($map as $column) {
            $sum += count($column);
        }


        return $sum;
    }

    public function secondPart(string $input)
    {
        $map = [];

        $mode = 0;

        foreach (InputGenerator::inputToLineGenerator($input) as $line) {
            $line = trim($line);
            if (empty($line)) {
                $mode = 1;
                continue;
            }

            if ($mode === 0) {
                [$x, $y] = explode(',', $line);
                $map[$y][$x] = 1;
            } else {
                preg_match('/fold along (?<dimension>[a-z])=(?<value>[0-9]+)/', $line, $matches);

                $this->fold($map, $matches['dimension'], $matches['value']);
            }
        }

        $maxColumn = max(array_keys(array_filter($map)));

        $result = '';

        for ($i = 0; $i <= $maxColumn; $i++) {
            if (!isset($map[$i]) || empty($map[$i])) {
                continue;
            }

            $maxRow = max(array_keys($map[$i]));
            for ($j = 0; $j <= $maxRow; $j++) {
                $result .= isset($map[$i][$j]) ? '#' : ' ';
            }

            if ($i != $maxColumn) {
                $result .= PHP_EOL;
            }
        }

        return $result;
    }

    public function fold(&$map, string $dimension, int $foldLine): void
    {
        foreach ($map as $row => $rows) {
            foreach ($rows as $column => $set) {
                if ($dimension === 'x') {
                    if ($column > $foldLine) {
                        $newColId = $foldLine + ($foldLine - $column);
                        $map[$row][$newColId] = 1;

                        unset($map[$row][$column]);
                    }
                } else {
                    if ($row > $foldLine) {
                        $newRowId = $foldLine + ($foldLine - $row);
                        $map[$newRowId][$column] = 1;

                        unset($map[$row][$column]);
                    }
                }
            }
        }

    }
}
