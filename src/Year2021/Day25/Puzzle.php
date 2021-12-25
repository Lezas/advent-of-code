<?php

namespace AdventOfCode\Year2021\Day25;

use AdventOfCode\PuzzleInterface;

class Puzzle implements PuzzleInterface
{
    public function firstPart(string $input)
    {
        $map = [];
        foreach (explode("\n", trim($input)) as $line) {
            $map[] = str_split(trim($line));
        }

        $charsCount = count($map[0]);
        $linesCount = count($map);

        $doneStep = true;
        $steps = 0;
        while ($doneStep == true) {
            $steps++;
            $doneStep = false;
            $newMap = [];
            //first go East
            foreach ($map as $line) {
                $newLine = [];
                for ($i = 0; $i < ($charsCount - 1); $i++) {
                    if ('>.' == $line[$i] . $line[$i + 1]) {
                        $doneStep = true;
                        $newLine[$i] = '.';
                        $newLine[$i + 1] = '>';
                        $i++;
                    } else {
                        $newLine[$i] = $line[$i];
                    }
                }

                if ('>.' == $line[$charsCount - 1] . $line[0]) {
                    $doneStep = true;
                    $newLine[0] = '>';
                    $newLine[$charsCount - 1] = '.';
                } else {
                    if (!isset($newLine[$charsCount - 1])) {
                        $newLine[$charsCount - 1] = $line[$charsCount - 1];
                    }
                }
                $newMap[] = $newLine;
            }

            $map = $newMap;

            //Go south
            $newMap = [];
            for ($columnId = 0; $columnId < $charsCount; $columnId++) {
                for ($lineId = 0; $lineId < ($linesCount - 1); $lineId++) {
                    if ('v.' == $map[$lineId][$columnId] . $map[$lineId + 1][$columnId]) {
                        $doneStep = true;
                        $newMap[$lineId][$columnId] = '.';
                        $newMap[$lineId + 1][$columnId] = 'v';
                        $lineId++;
                    } else {
                        $newMap[$lineId][$columnId] = $map[$lineId][$columnId];
                    }
                }

                if ('v.' == $map[$linesCount - 1][$columnId] . $map[0][$columnId]) {
                    $doneStep = true;
                    $newMap[$linesCount - 1][$columnId] = '.';
                    $newMap[0][$columnId] = 'v';
                } else {
                    if (!isset($newMap[$linesCount - 1][$columnId])) {
                        $newMap[$linesCount - 1][$columnId] = $map[$linesCount - 1][$columnId];
                    }
                }
            }

            $map = $newMap;
        }

        return $steps;
    }

    public function secondPart(string $input)
    {
        return 'Win!';
    }
}
