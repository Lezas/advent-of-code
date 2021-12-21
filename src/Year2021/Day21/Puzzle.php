<?php

namespace AdventOfCode\Year2021\Day21;

use AdventOfCode\PuzzleInterface;

class Puzzle implements PuzzleInterface
{
    private $memory = [];

    public function firstPart(string $input)
    {
        $players = preg_split('|\R|', $input);
        $p1Start = substr($players[0], -1);
        $p2Start = substr($players[1], -1);

        $p1Score = 0;
        $p2Score = 0;

        $dye = new Dye();

        while (1) {
            $score = $dye->getNextScore();
            $score += $dye->getNextScore();
            $score += $dye->getNextScore();

            $stepsToMove = $score % 10;
            $p1Start += $stepsToMove;
            $p1Start = $p1Start % 10;
            if ($p1Start == 0) {
                $p1Start = 10;
            }
            $p1Score += $p1Start;

            if ($p1Score >= 1000) {
                $looserScore = $p2Score;
                break;
            }
            $score = $dye->getNextScore();
            $score += $dye->getNextScore();
            $score += $dye->getNextScore();

            $stepsToMove = $score % 10;
            $p2Start += $stepsToMove;
            $p2Start = $p2Start % 10;
            if ($p2Start == 0) {
                $p2Start = 10;
            }
            $p2Score += $p2Start;

            if ($p2Score >= 1000) {
                $looserScore = $p1Score;
                break;
            }
        }

        return $looserScore * $dye->dyeRolls;
    }

    public function secondPart(string $input)
    {
        $players = preg_split('|\R|', $input);
        $p1Start = substr($players[0], -1);
        $p2Start = substr($players[1], -1);

        return max($this->roll([$p1Start, $p2Start], [0, 0]));
    }

    public function roll(array $positions, array $scores, int $player = 0): array
    {
        $hash = serialize(func_get_args());

        if (isset($this->memory[$hash])) {
            return $this->memory[$hash];
        }

        $newPositions = $positions;
        $newScores = $scores;
        $wins = [0, 0];
        foreach ($this->getRollsFrequency() as $roll => $frequency) {
            $newPositions[$player] = ($positions[$player] + $roll) % 10;
            if ($newPositions[$player] == 0) {
                $newPositions[$player] = 10;
            }
            $newScores[$player] = $scores[$player] + $newPositions[$player];
            if ($newScores[$player] >= 21) {
                $wins[$player] += $frequency;
            } else {
                [$player1Wins, $player2Wins] = $this->roll($newPositions, $newScores, 1 - $player);
                $wins[0] += $player1Wins * $frequency;
                $wins[1] += $player2Wins * $frequency;
            }
        }

        $this->memory[$hash] = $wins;

        return $wins;
    }

    public function getRollsFrequency(): array
    {
        static $frequency = null;
        if ($frequency !== null) {
            return $frequency;
        }
        $possibleCombinations = [];
        $possibleRolls = [1, 2, 3];
        foreach ($possibleRolls as $possibleRoll1) {
            foreach ($possibleRolls as $possibleRoll2) {
                foreach ($possibleRolls as $possibleRoll3) {
                    $possibleCombinations[] = [
                        $possibleRoll1,
                        $possibleRoll2,
                        $possibleRoll3,
                    ];
                }
            }
        }

        $frequency = [];

        foreach ($possibleCombinations as $possibleCombination) {
            $roll = array_sum($possibleCombination);
            $frequency[$roll] = ($frequency[$roll] ?? 0) + 1;
        }

        return $frequency;
    }
}

class Dye
{
    public $currentEye = 0;
    public $dyeRolls = 0;

    public function getNextScore(): int
    {
        $this->currentEye++;
        $this->dyeRolls++;
        if ($this->currentEye > 100) {
            $this->currentEye = 1;
        }

        return $this->currentEye;
    }
}
