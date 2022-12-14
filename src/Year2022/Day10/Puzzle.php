<?php

namespace AdventOfCode\Year2022\Day10;

use AdventOfCode\PuzzleInterface;

class Puzzle implements PuzzleInterface
{
    public function firstPart(string $input)
    {
        $lines = explode("\n", trim($input));
        $commands = [];

        foreach ($lines as $line) {
            preg_match('/(?<command>[a-z]*) ?(?<count>[0-9]*?)?/', trim($line), $matches);
            if (trim($line) === 'noop') {
                $commands[] = [
                    'command' => trim($line),
                    'count' => null,
                ];
            } else {
                preg_match('/(?<command>[a-z]*) (?<count>[0-9-]*)/', trim($line), $matches);
                $commands[] = [
                    'command' => $matches['command'],
                    'count' => (int)$matches['count'],
                ];
            }
        }

        $registerStrengthAt = [20,60,100,140, 180, 220];

        $x = 1;
        $executionState = 'begins';
        $command = null;
        $commandPointer = 0;
        $lines = [];
        $currentLineKey = 0;
        $currentLine = [];
        $result = 0;
        for ($i = 1; $i <= 240; $i++){
            if (in_array($i, $registerStrengthAt)) {
                $result += $i*$x;
            }
            if (count($commands) <= $commandPointer) {
                break;
            }

            if ($currentLineKey >= 40) {
                $lines[] = $currentLine;
                $currentLine = [];
                $currentLineKey = 0;
                echo PHP_EOL;
            }

            if (($currentLineKey +1 >= $x) && ($currentLineKey +1 <= $x +2)) {
                $currentLine[] = '#';
                echo '#';
            }else {
                $currentLine[] = '.';
                echo '.';
            }

            $currentLineKey++;

            if ($command === null) {
                $command = $commands[$commandPointer];
                $commandPointer++;
            }
            switch ($command['command']) {
                case 'noop': {
                    $command = null;
                }break;
                case 'addx': {
                    if ($executionState === 'begins') {
                        $executionState = 'runs';
                    } elseif ($executionState === 'runs') {
                        $x += $command['count'];
                        $command = null;
                        $executionState = 'begins';
                    }
                }break;
            }
        }

        return $result;
    }

    public function secondPart(string $input)
    {
        $lines = explode("\n", trim($input));
        $commands = [];

        foreach ($lines as $line) {
            preg_match('/(?<command>[a-z]*) ?(?<count>[0-9]*?)?/', trim($line), $matches);
            if (trim($line) === 'noop') {
                $commands[] = [
                    'command' => trim($line),
                    'count' => null,
                ];
            } else {
                preg_match('/(?<command>[a-z]*) (?<count>[0-9-]*)/', trim($line), $matches);
                $commands[] = [
                    'command' => $matches['command'],
                    'count' => (int)$matches['count'],
                ];
            }
        }

        $x = 1;
        $executionState = 'begins';
        $command = null;
        $commandPointer = 0;
        $lines = [];
        $currentLineKey = 0;
        $currentLine = [];
        for ($i = 1; $i <= 220; $i++){
            if (count($commands) <= $commandPointer) {
                break;
            }

            if ($currentLineKey >= 40) {
                $lines[] = $currentLine;
                $currentLine = [];
                $currentLineKey = 0;
                echo PHP_EOL;
            }

            if (($currentLineKey >= $x -1) && ($currentLineKey <= $x +2)) {
                $currentLine[] = '#';
                echo '#';
            }else {
                $currentLine[] = '.';
                echo '.';
            }

            echo implode(' ', [$currentLineKey . '|' , 'x:'. $x ,$command['command'].$command['count']]) . PHP_EOL;

            $currentLineKey++;
            if ($command === null) {
                $command = $commands[$commandPointer];
                $commandPointer++;
            }
            switch ($command['command']) {
                case 'noop': {
                    $command = null;
                }break;
                case 'addx': {
                    if ($executionState === 'begins') {
                        $executionState = 'runs';
                    } elseif ($executionState === 'runs') {
                        $x += $command['count'];
                        $command = null;
                        $executionState = 'begins';
                    }
                }
            }

//            echo implode(' ', [$command['command'], $i, $x, $commandPointer]) . PHP_EOL;

        }

//        var_dump($x);
        //Logic goes here


        return $result;
    }
}
