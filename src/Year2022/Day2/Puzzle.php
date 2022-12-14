<?php

namespace AdventOfCode\Year2022\Day2;

use AdventOfCode\PuzzleInterface;

class Puzzle implements PuzzleInterface
{
    public function firstPart(string $input)
    {
        $points = [
            'X' => 1, //rock
            'Y' => 2, //paper
            'Z' => 3, //sizzors
        ];

        $comb = [
            'A' => [ //rock
                'X' => 0, //rock
                'Y' => 1, //paper
                'Z' => -1, //sizzors
            ],
            'B' => [ //paper
                'X' => -1, //rock
                'Y' => 0, //paper
                'Z' => 1, //sizzors
            ],
            'C' => [ //sizzors
                'X' => 1, //rock
                'Y' => -1, //paper
                'Z' => 0, //sizzors
            ],
        ];

        $lines = explode("\n", trim($input));

        $totalPoints = 0;
        foreach ($lines as $line) {
            $forms = explode(" ", trim($line));
            $opponent = $forms[0];
            $you = $forms[1];

            $totalPoints += $points[$you];

            $result = $comb[$opponent][$you];

            switch ($result) {
                case 0:
                    $totalPoints += 3;
                    break;
                case 1:
                    $totalPoints += 6;
                    break;
            }
        }

        return $totalPoints;
    }

    public function secondPart(string $input)
    {
        $points = [
            'X' => 1, //rock
            'Y' => 2, //paper
            'Z' => 3, //sizzors
        ];

        $what = [
            'X' => 'loose',
            'Y' => 'draw',
            'Z' => 'win',
        ];

        $comb = [
            'A' => [ //rock
                'X' => 0, //rock
                'Y' => 1, //paper
                'Z' => -1, //sizzors
            ],
            'B' => [ //paper
                'X' => -1, //rock
                'Y' => 0, //paper
                'Z' => 1, //sizzors
            ],
            'C' => [ //sizzors
                'X' => 1, //rock
                'Y' => -1, //paper
                'Z' => 0, //sizzors
            ],
        ];

        $lines = explode("\n", trim($input));

        $totalPoints = 0;
        foreach ($lines as $line) {
            $forms = explode(" ", trim($line));
            $opponent = $forms[0];
            $you = $forms[1];

            $whatToDo = $what[$you];
            var_dump($whatToDo);

            switch ($whatToDo) {
                case 'loose':
                {
                    $combinations = $comb[$opponent];
                    foreach ($combinations as $key => $result) {
                        if ($result == -1) {
                            $youChosen = $key;
                            var_dump($youChosen);
                            $totalPoints += $points[$youChosen];
                        }
                    }
                }
                    break;
                case 'draw':
                {
                    $combinations = $comb[$opponent];
                    foreach ($combinations as $key => $result) {
                        if ($result == 0) {
                            $youChosen = $key;
                            var_dump($youChosen);
                            $totalPoints += $points[$youChosen];
                            $totalPoints += 3;
                        }
                    }
                }
                    break;
                case 'win':
                {
                    $combinations = $comb[$opponent];
                    foreach ($combinations as $key => $result) {
                        if ($result == 1) {
                            $youChosen = $key;
                            var_dump($youChosen);
                            $totalPoints += $points[$youChosen];
                            $totalPoints += 6;
                        }
                    }
                }
                    break;
            }

        }

        return $totalPoints;
    }
}
