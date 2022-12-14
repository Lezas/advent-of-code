<?php

namespace AdventOfCode\Year2022\Day11;

use AdventOfCode\PuzzleInterface;

class Puzzle implements PuzzleInterface
{
    public function firstPart(string $input)
    {
        $bySingleMonkey = explode("\n\n", trim($input));

        $monkeys = [];
        foreach ($bySingleMonkey as $singleMonkeyInput) {
            $singleMonkeyLines = explode("\n", trim($singleMonkeyInput));
            $startingItems = explode(', ', str_replace('Starting items: ', '', trim($singleMonkeyLines[1]))); //ok

            preg_match('/(?<command>[a-zA-Z]*) (?<count>[0-9]*):/', trim($singleMonkeyLines[0]), $matches);
            $monkeyId = $matches['count']; //ok


            preg_match('/Operation: new = old (?<operator>.{1,1}) (?<variable>.*)/', trim($singleMonkeyLines[2]),
                $matches);

            $variable = $matches['variable'];

            if ($variable == 'old') {
                if ($matches['operator'] == '+') {
                    $operationFunction = function (int $number): int {
                        return $number + $number;
                    };
                } elseif ($matches['operator'] == '*') {
                    $operationFunction = function (int $number): int {
                        return (int)($number * $number);
                    };
                }
            } else {
                if ($matches['operator'] == '+') {
                    $operationFunction = function (int $number) use ($variable): int {
                        return $number + $variable;
                    };
                } elseif ($matches['operator'] == '*') {
                    $operationFunction = function (int $number) use ($variable): int {
                        return (int)($number * $variable);
                    };
                }
            }

            preg_match('/Test: divisible by (?<variable>[0-9]*)/', trim($singleMonkeyLines[3]), $matches);

            $divisableBy = $matches['variable'];

            preg_match('/If true: throw to monkey (?<variable>[0-9]*)/', trim($singleMonkeyLines[4]), $matches);

            $ifTrueThrowToMonkey = $matches['variable'];

            preg_match('/If false: throw to monkey (?<variable>[0-9]*)/', trim($singleMonkeyLines[5]), $matches);

            $ifFalseThrowToMonkey = $matches['variable'];

            $monkeys[$monkeyId] = [
                'id'              => $monkeyId,
                'items'           => $startingItems,
                'operation'       => $operationFunction,
                'testDivisibleBy' => $divisableBy,
                'ifTrueToMonkey'  => $ifTrueThrowToMonkey,
                'ifFalseToMonkey' => $ifFalseThrowToMonkey,
                'inspectedCount'  => 0,
            ];
        }

        $inspectAfterRounds = [1, 20, 1000, 2000, 3000, 4000, 5000, 6000, 7000, 8000, 9000, 10000];

        for ($round = 1; $round <= 1000; $round++) {
            foreach ($monkeys as $monkeyId => &$monkey) {
                foreach ($monkey['items'] as $key => &$item) {
                    $monkey['inspectedCount']++;

                    $operationFunction = $monkey['operation'];
                    $itemWorryLevel = $operationFunction((int)$item);

                    $itemWorryLevel = (int)($itemWorryLevel / 3);
                    if ($itemWorryLevel % $monkey['testDivisibleBy'] == 0) {
                        $monkeys[$monkey['ifTrueToMonkey']]['items'][] = $itemWorryLevel;
                    } else {
                        $monkeys[$monkey['ifFalseToMonkey']]['items'][] = $itemWorryLevel;
                    }
                }
                $monkey['items'] = [];
            }

            if (in_array($round, $inspectAfterRounds)) {
                echo "== After round $round ==" . PHP_EOL;
                foreach ($monkeys as $monkeyId => &$monkey) {
                    echo "Monkey $monkeyId inspected items {$monkey['inspectedCount']} times." . PHP_EOL;
                }
            }
        }

        $totals = [];
        foreach ($monkeys as &$monkey) {
            $totals[] = $monkey['inspectedCount'];
        }

        rsort($totals);

        return $totals[0] * $totals[1];
    }

    public function secondPart(string $input)
    {
        $bySingleMonkey = explode("\n\n", trim($input));

        $monkeys = [];
        foreach ($bySingleMonkey as $singleMonkeyInput) {
            $singleMonkeyLines = explode("\n", trim($singleMonkeyInput));
            $startingItems = explode(', ', str_replace('Starting items: ', '', trim($singleMonkeyLines[1])));

            preg_match('/(?<command>[a-zA-Z]*) (?<count>[0-9]*):/', trim($singleMonkeyLines[0]), $matches);
            $monkeyId = $matches['count']; //ok


            preg_match('/Operation: new = old (?<operator>.{1,1}) (?<variable>.*)/', trim($singleMonkeyLines[2]),
                $matches);

            $variable = $matches['variable'];

            if ($variable == 'old') {
                if ($matches['operator'] == '+') {
                    $operationFunction = function ($number) {
                        return bcadd($number, $number);
                    };
                } elseif ($matches['operator'] == '*') {
                    $operationFunction = function ($number) {
                        return bcmul($number, $number);
                    };
                }
            } else {
                if ($matches['operator'] == '+') {
                    $operationFunction = function ($number) use ($variable) {
                        return bcadd($number, $variable);
                    };
                } elseif ($matches['operator'] == '*') {
                    $operationFunction = function ($number) use ($variable) {
                        return bcmul($number, $variable);
                    };
                }
            }

            preg_match('/Test: divisible by (?<variable>[0-9]*)/', trim($singleMonkeyLines[3]), $matches);

            $divisableBy = $matches['variable'];

            preg_match('/If true: throw to monkey (?<variable>[0-9]*)/', trim($singleMonkeyLines[4]), $matches);

            $ifTrueThrowToMonkey = $matches['variable'];

            preg_match('/If false: throw to monkey (?<variable>[0-9]*)/', trim($singleMonkeyLines[5]), $matches);

            $ifFalseThrowToMonkey = $matches['variable'];

            $monkeys[$monkeyId] = [
                'id'              => $monkeyId,
                'items'           => $startingItems,
                'operation'       => $operationFunction,
                'testDivisibleBy' => $divisableBy,
                'ifTrueToMonkey'  => $ifTrueThrowToMonkey,
                'ifFalseToMonkey' => $ifFalseThrowToMonkey,
                'inspectedCount'  => 0,
            ];
        }

        $divisableByNumbers = [];

        foreach ($monkeys as $monkey) {
            $divisableByNumbers[] = $monkey['testDivisibleBy'];
        }

        $gcd = array_product($divisableByNumbers);

        for ($round = 1; $round <= 10000; $round++) {
            foreach ($monkeys as $monkeyId => &$monkey) {
                foreach ($monkey['items'] as $key => &$item) {
                    $monkey['inspectedCount']++;

                    $operationFunction = $monkey['operation'];
                    $itemWorryLevel = $operationFunction($item);

                    $itemWorryLevel = $itemWorryLevel % $gcd;

                    if (bcmod($itemWorryLevel, $monkey['testDivisibleBy']) == 0) { //if true
                        $monkeys[$monkey['ifTrueToMonkey']]['items'][] = $itemWorryLevel;
                    } else { //if false
                        $monkeys[$monkey['ifFalseToMonkey']]['items'][] = $itemWorryLevel;
                    }
                }
                $monkey['items'] = [];
            }
        }

        $totals = [];
        foreach ($monkeys as &$monkey) {
            $totals[] = $monkey['inspectedCount'];
        }

        rsort($totals);

        return $totals[0] * $totals[1];
    }
}
