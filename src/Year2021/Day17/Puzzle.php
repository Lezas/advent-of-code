<?php

namespace AdventOfCode\Year2021\Day17;

use AdventOfCode\PuzzleInterface;

class Puzzle implements PuzzleInterface
{
    private $targetArea = [['x' => 138, 'y' => -71], ['x' => 184, 'y' => -125]];

    public function firstPart(string $input)
    {
        preg_match(
            '|target area: x=(?<x1>[0-9]*)\.\.(?<x2>[0-9]*), y=(?<y1>[0-9\-]*)\.\.(?<y2>[0-9\-]*)|',
            $input,
            $matches
        );

        $this->targetArea = [
            ['x' => $matches['x1'], 'y' => $matches['y2']],
            ['x' => $matches['x2'], 'y' => $matches['y1']]
        ];

        [
            'maxDistance' => $maxDistance,
            'availableVelocities' => $availableVelocities
        ] = $this->calculateAvailablePaths();

        return $maxDistance;
    }

    public function secondPart(string $input)
    {
        preg_match(
            '|target area: x=(?<x1>[0-9]*)\.\.(?<x2>[0-9]*), y=(?<y1>[0-9\-]*)\.\.(?<y2>[0-9\-]*)|',
            $input,
            $matches
        );

        $this->targetArea = [
            ['x' => $matches['x1'], 'y' => $matches['y2']],
            ['x' => $matches['x2'], 'y' => $matches['y1']]
        ];

        [
            'maxDistance' => $maxDistance,
            'availableVelocities' => $availableVelocities
        ] = $this->calculateAvailablePaths();

        return $availableVelocities;
    }

    public function calculateAvailablePaths()
    {
        $maxDistance = 0;
        //Brute force FTW!
        $maxSteps = $this->targetArea[1]['x'] * 2;
        $availableVelocities = [];
        for ($i = 1; $i <= $maxSteps; $i++) {
            $xVelocities = $this->findAvailalbeVelocitiesForStep($i);
            if ($xVelocities == false) {
                continue;
            }
            $yVelocities = $this->findAvailableYVelocitiesForStep($i);

            if (false == $yVelocities || $xVelocities == false) {
                continue;
            }

            foreach ($xVelocities as $XVelocity) {
                foreach ($yVelocities as ['velocity' => $velocity, 'peakDistance' => $peakDistance]) {
                    $availableVelocities[$XVelocity . $velocity] = 1;
                }
            }

            $peakDistance = 0;
            foreach ($yVelocities as $yVelocity) {
                if ($yVelocity['peakDistance'] > $peakDistance) {
                    $peakDistance = $yVelocity['peakDistance'];
                }
            }

            if ($maxDistance < $peakDistance) {
                $maxDistance = $peakDistance;
            }
        }

        return ['maxDistance' => $maxDistance, 'availableVelocities' => count($availableVelocities)];
    }

    private function findAvailalbeVelocitiesForStep(int $step)
    {
        $velocities = [];
        $velocity = ($this->targetArea[1]['x'] + 1) * 2;
        while (--$velocity) {
            $distance = $this->calculateSum($velocity, $step, 1, false);

            if ($distance < 0) {
                continue;
            }
            if ($distance >= $this->targetArea[0]['x'] && $distance <= $this->targetArea[1]['x']) {
                $velocities[] = $velocity;
            }
        }

        if (empty($velocities)) {
            return false;
        }

        return $velocities;
    }

    private function findAvailableYVelocitiesForStep(int $step)
    {
        $velocities = [];
        $velocity = abs($this->targetArea[0]['y']) * 2000;
        $minVelocity = $this->targetArea[1]['y'];
        while (--$velocity >= $minVelocity) {
            $distance = $this->calculateSum($velocity, $step, 1);

            if ($distance >= $this->targetArea[1]['y'] && $distance <= $this->targetArea[0]['y']) {
                $peakDistance = $this->findPeakDistance($step, $velocity);
                $velocities[] = ['velocity' => $velocity, 'peakDistance' => $peakDistance];
            }
        }

        if (empty($velocities)) {
            return false;
        }

        return $velocities;
    }

    private function findPeakDistance($step, $velocity): int
    {
        $peakDistance = -999999;
        for ($i = 1; $i <= $step; $i++) {
            $distance = $this->calculateSum($velocity, $i, 1);
            if ($distance > $peakDistance) {
                $peakDistance = $distance;
            }
        }

        return $peakDistance;
    }

    public function calculateSum($number, $steps, $decreaseBy, $goBackwards = true): int
    {
        $totalSum = 0;
        for ($i = 1; $i <= $steps; $i++) {
            $totalSum += $number;
            $number = $number - $decreaseBy;

            if ($goBackwards == false && $number <= 0) {
                return $totalSum;
            }
        }

        return $totalSum;
    }
}
