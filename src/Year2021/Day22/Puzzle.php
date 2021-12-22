<?php

namespace AdventOfCode\Year2021\Day22;

use AdventOfCode\PuzzleInterface;

class Puzzle implements PuzzleInterface
{
    public function firstPart(string $input)
    {
        $instructions = [];
        foreach (explode("\n", trim($input)) as $line) {
            [$operation, $ranges] = explode(' ', trim($line));
            preg_match(
                '|x=(?<x1>[0-9\-]*)\.\.(?<x2>[0-9\-]*),y=(?<y1>[0-9\-]*)\.\.(?<y2>[0-9\-]*),z=(?<z1>[0-9\-]*)\.\.(?<z2>[0-9\-]*)|'
                ,
                $ranges,
                $matches
            );
            $instructions[] = [
                'operation' => $operation,
                'x' => [
                    $matches['x1'],
                    $matches['x2'],
                ],
                'y' => [
                    $matches['y1'],
                    $matches['y2'],
                ],
                'z' => [
                    $matches['z1'],
                    $matches['z2'],
                ],
            ];
        }

        $rangeToMeet = [-50, 50];

        $cubes = [];
        foreach ($instructions as $instruction) {
            $operation = $instruction['operation'];
            $xOverlap = $this->overlap($rangeToMeet, [$instruction['x'][0], $instruction['x'][1]]);
            $yOverlap = $this->overlap($rangeToMeet, [$instruction['y'][0], $instruction['y'][1]]);
            $zOverlap = $this->overlap($rangeToMeet, [$instruction['z'][0], $instruction['z'][1]]);
            if (false === $xOverlap || false == $yOverlap || false == $zOverlap) {
                continue;
            }
            for ($x = $xOverlap[0]; $x <= $xOverlap[1]; $x++) {
                for ($y = $yOverlap[0]; $y <= $yOverlap[1]; $y++) {
                    for ($z = $zOverlap[0]; $z <= $zOverlap[1]; $z++) {
                        $key = implode('.', [$x, $y, $z]);
                        if ($operation == 'on') {
                            $cubes[$key] = 1;
                        } else {
                            $cubes[$key] = 0;
                        }
                    }
                }
            }
        }

        return array_sum($cubes);
    }

    private function overlap(array $rangeToMeet, array $range)
    {
        $returnRange = [];
        if ($range[0] <= $rangeToMeet[0]) {
            $returnRange[0] = $rangeToMeet[0];
        } elseif ($range[0] <= $rangeToMeet[1]) {
            $returnRange[0] = $range[0];
        } else {
            return false;
        }

        if ($range[1] >= $rangeToMeet[1]) {
            $returnRange[1] = $rangeToMeet[1];
        } elseif ($range[1] >= $rangeToMeet[0]) {
            $returnRange[1] = $range[1];
        } else {
            return false;
        }

        return $returnRange;
    }

    public function secondPart(string $input)
    {
        $lines = explode("\n", trim($input));
        $instructions = [];

        foreach ($lines as $line) {
            [$operation, $ranges] = explode(' ', trim($line));
            preg_match(
                '|x=(?<x1>[0-9\-]*)\.\.(?<x2>[0-9\-]*),y=(?<y1>[0-9\-]*)\.\.(?<y2>[0-9\-]*),z=(?<z1>[0-9\-]*)\.\.(?<z2>[0-9\-]*)|',
               $ranges,
               $matches
           );
           $instructions[] = [
               'operation' => $operation,
               'x'         => [
                   $matches['x1'],
                   $matches['x2'] + 1,
                   //since range ends are inclusive, need to expand the range by 1.
                   //(f.e. range 10..10 has 1 cube. But if have coordinates x=(10;10) and try to know how
                   //many cubes are in this range, we would perform x1 - x2, and we would get 0. By expanding by 1 the
                   //range, include the 0th cube in range.
               ],
               'y'         => [
                   $matches['y1'],
                   $matches['y2'] + 1,
               ],
               'z'         => [
                   $matches['z1'],
                   $matches['z2'] + 1,
               ],
           ];
       }


       $cubes = [];
       $instruction = array_shift($instructions);
       $cubes[] = [
           'x' => $instruction['x'],
           'y' => $instruction['y'],
           'z' => $instruction['z'],
       ];
       foreach ($instructions as $instruction) {
           $cube = [
               'x' => $instruction['x'],
               'y' => $instruction['y'],
               'z' => $instruction['z'],
           ];
           if ($instruction['operation'] == 'on') {
               $cubesToAdd = [$cube];
               foreach ($cubes as $existingCube) {
                   $newCubes = [];
                   foreach ($cubesToAdd as $cubeToAdd) {
                       if ($this->cubeExistInCube($cubeToAdd, $existingCube)) {
                           //existing cube fully covers new cube, no need to add
                           continue;
                       }
                       if (!$this->cubeIntersectWithCube($cubeToAdd, $existingCube)) {
                           //cubes do not overlap - new cube can be added without modifications
                           $newCubes[] = $cubeToAdd;
                           continue;
                       }

                       foreach ($this->substractCube($cubeToAdd, $existingCube) as $addCube) {
                           $newCubes[] = $addCube;
                       }
                   }
                   $cubesToAdd = $newCubes;
               }

               foreach ($cubesToAdd as $item) {
                   $cubes[] = $item;
               }
           } else {
               $newCubes = [];
               foreach ($cubes as $existingCube) {
                   if (!$this->cubeIntersectWithCube($existingCube, $cube)) {
                       $newCubes[] = $existingCube;
                       continue;
                   }
                   if ($this->cubeExistInCube($existingCube, $cube)) {
                       continue;
                   }
                   foreach ($this->substractCube($existingCube, $cube) as $addCube) {
                       $newCubes[] = $addCube;
                   }
               }
               $cubes = $newCubes;
           }
       }

       $sum = 0;

       foreach ($cubes as $cube) {
           $sum += ($cube['x'][1] - $cube['x'][0])
               * ($cube['y'][1] - $cube['y'][0])
               * ($cube['z'][1] - $cube['z'][0]);
       }

       return $sum;
   }

   private function cubeExistInCube(array $cubeToCheck, array $cubeToCheckAgainst): bool
   {
       if (
           $cubeToCheck['x'][0] >= $cubeToCheckAgainst['x'][0] && $cubeToCheck['x'][1] <= $cubeToCheckAgainst['x'][1]
           && $cubeToCheck['y'][0] >= $cubeToCheckAgainst['y'][0] && $cubeToCheck['y'][1] <= $cubeToCheckAgainst['y'][1]
           && $cubeToCheck['z'][0] >= $cubeToCheckAgainst['z'][0] && $cubeToCheck['z'][1] <= $cubeToCheckAgainst['z'][1]
       ) {
           return true;
       }

       return false;
   }

   private function cubeIntersectWithCube(array $cubeToCheck, array $cubeToCheckAgainst): bool
   {
       if (
           $cubeToCheck['x'][0] < $cubeToCheckAgainst['x'][1] && $cubeToCheck['x'][1] > $cubeToCheckAgainst['x'][0]
           && $cubeToCheck['y'][0] < $cubeToCheckAgainst['y'][1] && $cubeToCheck['y'][1] > $cubeToCheckAgainst['y'][0]
           && $cubeToCheck['z'][0] < $cubeToCheckAgainst['z'][1] && $cubeToCheck['z'][1] > $cubeToCheckAgainst['z'][0]
       ) {
           return true;
       }

       return false;
   }

   private function substractCube(array $removeFrom, array $removeWhat): array
   {
       $xOverlap = $this->overlap($removeWhat['x'], $removeFrom['x']);
       $yOverlap = $this->overlap($removeWhat['y'], $removeFrom['y']);
       $zOverlap = $this->overlap($removeWhat['z'], $removeFrom['z']);

       $newCubes = [];
       $tmp = $removeFrom;

       if ($xOverlap[0] > $removeFrom['x'][0]) {
           $tmp['x'][1] = $xOverlap[0];
           $newCubes[] = $tmp;
       }

       $tmp = $removeFrom;
       if ($xOverlap[1] < $removeFrom['x'][1]) {
           $tmp['x'][0] = $xOverlap[1];
           $newCubes[] = $tmp;
       }

       $tmp = $removeFrom;
       $tmp['x'][0] = $xOverlap[0];
       $tmp['x'][1] = $xOverlap[1];
       if ($yOverlap[0] > $removeFrom['y'][0]) {
           $tmp['y'][1] = $yOverlap[0];
           $newCubes[] = $tmp;
       }

       $tmp = $removeFrom;
       $tmp['x'][0] = $xOverlap[0];
       $tmp['x'][1] = $xOverlap[1];
       if ($yOverlap[1] < $removeFrom['y'][1]) {
           $tmp['y'][0] = $yOverlap[1];
           $newCubes[] = $tmp;
       }

       $tmp = $removeFrom;
       $tmp['x'][0] = $xOverlap[0];
       $tmp['x'][1] = $xOverlap[1];
       $tmp['y'][0] = $yOverlap[0];
       $tmp['y'][1] = $yOverlap[1];
       if ($zOverlap[0] > $removeFrom['z'][0]) {
           $tmp['z'][1] = $zOverlap[0];
           $newCubes[] = $tmp;
       }

       $tmp = $removeFrom;
       $tmp['x'][0] = $xOverlap[0];
       $tmp['x'][1] = $xOverlap[1];
       $tmp['y'][0] = $yOverlap[0];
       $tmp['y'][1] = $yOverlap[1];
       if ($zOverlap[1] < $removeFrom['z'][1]) {
           $tmp['z'][0] = $zOverlap[1];
           $newCubes[] = $tmp;
       }

       return $newCubes;
   }
}
