<?php

namespace AdventOfCode\Year2021\Day19;

use AdventOfCode\PuzzleInterface;

class Puzzle implements PuzzleInterface
{
    public function firstPart(string $input)
    {
        $scannerInput = preg_split("/\R\R/", trim($input));
        /** @var Scanner[] $scanners */
        $scanners = [];

        foreach ($scannerInput as $linesString) {
            $lines = preg_split("/\R/", trim($linesString));
            $scanner = new Scanner();
            $scanners[] = $scanner;
            $count = count($lines);
            for ($i = 1; $i < $count; $i++) {
                [$x, $y, $z] = explode(',', $lines[$i]);
                $scanner->addRelativeBeaconPosition((int)$x, (int)$y, (int)$z);
            }
        }

        $mappedScanners = $this->mappScanners($scanners);

        $points = [];

        foreach ($mappedScanners as $scanner) {
            foreach ($scanner->relativeBeaconPositions as $relativeBeaconPosition) {
                $x = $relativeBeaconPosition[$scanner->absoluteOrder['x']];
                $y = $relativeBeaconPosition[$scanner->absoluteOrder['y']];
                $z = $relativeBeaconPosition[$scanner->absoluteOrder['z']];
                $x = $x * $scanner->absoluteRotation['x'] + $scanner->absolutePoint['x'];
                $y = $y * $scanner->absoluteRotation['y'] + $scanner->absolutePoint['y'];
                $z = $z * $scanner->absoluteRotation['z'] + $scanner->absolutePoint['z'];
                $points[$x][$y][$z] = ($points[$x][$y][$z] ?? 0) + 1;
            }
        }
        $result = 0;
        foreach ($points as $pointsX) {
            foreach ($pointsX as $pointsY) {
                foreach ($pointsY as $pointsZ) {
                    $result++;
                }
            }
        }

        return $result;
    }

    public function secondPart(string $input)
    {
        $scannersInput = preg_split("/\R\R/", trim($input));
        /** @var Scanner[] $scanners */
        $scanners = [];

        foreach ($scannersInput as $scannerInput) {
            $lines = preg_split("/\R/", trim($scannerInput));
            $scanner = new Scanner();
            $scanners[] = $scanner;
            $count = count($lines);
            for ($i = 1; $i < $count; $i++) {
                [$x, $y, $z] = explode(',', $lines[$i]);
                $scanner->addRelativeBeaconPosition((int)$x, (int)$y, (int)$z);
            }
        }

        $mappedScanners = $this->mappScanners($scanners);
        $maxDistance = 0;
        $count = count($mappedScanners);
        for ($i = 0; $i < ($count - 1); $i++) {
            for ($j = $i + 1; $j < ($count); $j++) {
                $scanner1 = $mappedScanners[$i];
                $scanner2 = $mappedScanners[$j];
                $x = abs($scanner1->absolutePoint['x'] - $scanner2->absolutePoint['x']);
                $y = abs($scanner1->absolutePoint['y'] - $scanner2->absolutePoint['y']);
                $z = abs($scanner1->absolutePoint['z'] - $scanner2->absolutePoint['z']);
                $distance = $x + $y + $z;
                if ($distance > $maxDistance) {
                    $maxDistance = $distance;
                }
            }
        }


        return $maxDistance;
    }

    private function mappScanners(array $scanners): array
    {
        $initialScanner = $scanners[0];
        $initialScanner->setAbsolutePoint(0, 0, 0);
        $initialScanner->setAbsoluteOrder('x', 'y', 'z');
        $initialScanner->setAbsoluteRotation(1, 1, 1);
        /** @var Scanner[] $mappedScanners */
        $mappedScanners = [];
        $mappedScanners[0] = $initialScanner;
        unset($scanners[0]);

        while (!empty($scanners)) {
            $found = false;
            foreach ($scanners as $key => $scanner) {
                foreach ($mappedScanners as $mappedKey => $mappedScanner) {
                    if ($this->determineIfBeaconsOverlap($mappedScanner, $scanner)) {
                        $mappedScanners[$key] = $scanner;
                        unset($scanners[$key]);

                        $found = true;
                    }
                }
            }

            if (!$found && count($scanners) > 0) {
                echo 'Something went wrong, did not find any scanners but there are in the queue' . PHP_EOL;
                exit();
            }
        }

        return $mappedScanners;
    }

    private function determineIfBeaconsOverlap(Scanner $mappedScanner, Scanner $scanner): bool
    {
        foreach ($this->getPossibleOrders() as $possibleOrder) {
            foreach ($this->getPossibleRotations() as $possibleRotation) {
                $distancesCount = [
                    'x' => [],
                    'y' => [],
                    'z' => [],
                ];
                foreach ($mappedScanner->relativeBeaconPositions as $beaconPosition) {
                    $x = $beaconPosition[$mappedScanner->absoluteOrder['x']];
                    $y = $beaconPosition[$mappedScanner->absoluteOrder['y']];
                    $z = $beaconPosition[$mappedScanner->absoluteOrder['z']];
                    foreach ($scanner->relativeBeaconPositions as $beaconPosition) {
                        $rx = $beaconPosition[$possibleOrder['x']] * $possibleRotation['x'];
                        $ry = $beaconPosition[$possibleOrder['y']] * $possibleRotation['y'];
                        $rz = $beaconPosition[$possibleOrder['z']] * $possibleRotation['z'];

                        $distance = ($x * $mappedScanner->absoluteRotation['x']) - $rx;
                        $distancesCount['x'][$distance] = ($distancesCount['x'][$distance] ?? 0) + 1;

                        $distance = ($y * $mappedScanner->absoluteRotation['y']) - $ry;
                        $distancesCount['y'][$distance] = ($distancesCount['y'][$distance] ?? 0) + 1;

                        $distance = ($z * $mappedScanner->absoluteRotation['z']) - $rz;
                        $distancesCount['z'][$distance] = ($distancesCount['z'][$distance] ?? 0) + 1;
                    }
                }
                $overLapFound = [
                    'x' => [
                        'founded' => false,
                        'distance' => 0,
                    ],
                    'y' => [
                        'founded' => false,
                        'distance' => 0,
                    ],
                    'z' => [
                        'founded' => false,
                        'distance' => 0,
                    ],
                ];
                foreach ($distancesCount as $axis => $counts) {
                    foreach ($counts as $distance => $count) {
                        if ($count >= 12) {
                            $overLapFound[$axis]['founded'] = true;
                            $overLapFound[$axis]['distance'] = $distance;
                        }
                    }
                }

                if (
                    $overLapFound['x']['founded'] === true
                    && $overLapFound['y']['founded'] === true
                    && $overLapFound['z']['founded'] === true
                ) {
                    $scanner->setAbsoluteRotation(
                        $possibleRotation['x'],
                        $possibleRotation['y'],
                        $possibleRotation['z']
                    );

                    $scanner->setAbsoluteOrder($possibleOrder['x'], $possibleOrder['y'], $possibleOrder['z']);
                    $scanner->setAbsolutePoint(
                        $mappedScanner->absolutePoint['x'] + $overLapFound['x']['distance'],
                        $mappedScanner->absolutePoint['y'] + $overLapFound['y']['distance'],
                        $mappedScanner->absolutePoint['z'] + $overLapFound['z']['distance']
                    );

                    return true;
                }
            }
        }

        return false;
    }


    private function getPossibleRotations()
    {
        static $rotations = null;
        if ($rotations !== null) {
            return $rotations;
        }
        $rotation = [1, -1];
        $rotations = [];
        foreach ($rotation as $xRotation) {
            foreach ($rotation as $yRotation) {
                foreach ($rotation as $zRotation) {
                    $rotations[] = ['x' => $xRotation, 'y' => $yRotation, 'z' => $zRotation];
                }
            }
        }

        return $rotations;
    }

    private function getPossibleOrders()
    {
        static $orders = null;
        if ($orders !== null) {
            return $orders;
        }
        $order = ['x', 'y', 'z'];
        $orders = [];
        foreach ($order as $xOrder) {
            foreach ($order as $yOrder) {
                if ($yOrder == $xOrder) {
                    continue;
                }
                foreach ($order as $zOrder) {
                    if ($zOrder == $xOrder || $zOrder == $yOrder) {
                        continue;
                    }
                    $orders[] = ['x' => $xOrder, 'y' => $yOrder, 'z' => $zOrder];
                }
            }
        }

        return $orders;
    }
}

class Scanner
{
    public $absolutePoint;
    public $relativeBeaconPositions = [];
    public $absoluteRotation;
    public $absoluteOrder;

    public function addRelativeBeaconPosition(int $x, int $y, int $z)
    {
        $this->relativeBeaconPositions[] = [
            'x' => $x,
            'y' => $y,
            'z' => $z,
        ];
    }

    public function setAbsolutePoint(int $x, int $y, int $z)
    {
        $this->absolutePoint = [
            'x' => $x,
            'y' => $y,
            'z' => $z,
        ];
    }

    public function setAbsoluteRotation(int $x, int $y, int $z)
    {
        $this->absoluteRotation = [
            'x' => $x,
            'y' => $y,
            'z' => $z,
        ];
    }

    public function setAbsoluteOrder(string $x, string $y, string $z)
    {
        $this->absoluteOrder = [
            'x' => $x,
            'y' => $y,
            'z' => $z,
        ];
    }
}
