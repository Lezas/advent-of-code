<?php

namespace AdventOfCode\Year2021\Day6;

use AdventOfCode\PuzzleInterface;

class Puzzle implements PuzzleInterface
{
    public function firstPart(string $input)
    {
        $fishes = explode(',', trim(preg_replace('/\s+/', ' ', $input)));

        $groups = array_count_values($fishes);

        $generations = [];

        $totalFishes = 0;
        $days = 80;

        foreach ($groups as $countOfDays => $count) {
            $generation = new Generation();
            $generation->leftDays = $countOfDays;
            $generation->countOfFishes = $count;
            $totalFishes += $count;
            $generations[] = $generation;
        }

        for ($day = 1; $day <= $days; $day++) {
            $maxCount = count($generations);
            for ($generationId = 0; $generationId < $maxCount; $generationId++) {
                $generation = $generations[$generationId];
                $generation->leftDays -= 1;
                if ($generation->leftDays < 0) {
                    $generation->leftDays = 6;
                    $newGeneration = new Generation();
                    $newGeneration->countOfFishes = $generation->countOfFishes;
                    $newGeneration->leftDays = 8;
                    $generations[] = $newGeneration;
                    $totalFishes += $newGeneration->countOfFishes;
                }
            }

            $generations = $this->groupNewGenerations($generations);
        }

        return $totalFishes;
    }

    public function secondPart(string $input)
    {
        $fishes = explode(',', trim(preg_replace('/\s+/', ' ', $input)));

        $groups = array_count_values($fishes);

        $generations = [];

        $totalFishes = 0;
        $days = 256;

        foreach ($groups as $countOfDays => $count) {
            $generation = new Generation();
            $generation->leftDays = $countOfDays;
            $generation->countOfFishes = $count;
            $totalFishes += $count;
            $generations[] = $generation;
        }

        for ($day = 1; $day <= $days; $day++) {
            $maxCount = count($generations);
            for ($generationId = 0; $generationId < $maxCount; $generationId++) {
                $generation = $generations[$generationId];
                $generation->leftDays -= 1;
                if ($generation->leftDays < 0) {
                    $generation->leftDays = 6;
                    $newGeneration = new Generation();
                    $newGeneration->countOfFishes = $generation->countOfFishes;
                    $newGeneration->leftDays = 8;
                    $generations[] = $newGeneration;
                    $totalFishes += $newGeneration->countOfFishes;
                }
            }

            $generations = $this->groupNewGenerations($generations);
        }

        return $totalFishes;
    }

    /**
     * @param array|Generation[] $generations
     */
    private function groupNewGenerations(array $generations): array
    {
        /** @var Generation[] $newGenerations */
        $newGenerations = [];
        $idWithDaysMap = [];
        foreach ($generations as $generation) {
            if (!isset($idWithDaysMap[$generation->leftDays])) {
                $newGenerations[] = $generation;
                $idWithDaysMap[$generation->leftDays] = array_key_last($newGenerations);
            } else {
                $newGeneration = $newGenerations[$idWithDaysMap[$generation->leftDays]];
                $newGeneration->countOfFishes += $generation->countOfFishes;
            }
        }

        return $newGenerations;
    }
}

class Generation
{
    public $countOfFishes;
    public $leftDays;
}