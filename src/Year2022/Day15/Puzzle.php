<?php

namespace AdventOfCode\Year2022\Day15;

use AdventOfCode\PuzzleInterface;

class Puzzle implements PuzzleInterface
{
    public function firstPart(string $input)
    {
        //brute forcing..
        ini_set('memory_limit', '4000 M');
        $lines = explode("\n", trim($input));
        $sensors = [];
        $beacons = [];
        foreach ($lines as $line) {
            preg_match(
                '/Sensor at x=(?<sensorX>[0-9-]*), y=(?<sensorY>[0-9-]*): closest beacon is at x=(?<beaconX>[0-9-]*), y=(?<beaconY>[0-9-]*)/',
                trim($line),
                $matches
            );
            $sensor = [
                'x' => $matches['sensorX'],
                'y' => $matches['sensorY'],
            ];
            $beacon = [
                'x' => $matches['beaconX'],
                'y' => $matches['beaconY'],
            ];
            $beacons[] = $beacon;

            if ($sensor['x'] == $beacon['x']) {
                if ($beacon['y'] > $sensor['y']) {
                    $h = $beacon['y'] - $sensor['y'];
                } else {
                    $h = $sensor['y'] - $beacon['y'];
                }
            } elseif ($sensor['y'] == $beacon['y']) {
                if ($beacon['x'] > $sensor['x']) {
                    $h = $beacon['x'] - $sensor['x'];
                } else {
                    $h = $sensor['x'] - $beacon['x'];
                }
            } else {
                //left down
                if ($beacon['y'] < $sensor['y'] && $beacon['x'] < $sensor['x']) {
                    $dy = $sensor['y'] - $beacon['y'];
                    $dx = $sensor['x'] - $beacon['x'];
                    $h = $dy + $dx;
                } //left up
                else {
                    if ($beacon['y'] > $sensor['y'] && $beacon['x'] < $sensor['x']) {
                        $dy = $beacon['y'] - $sensor['y'];
                        $dx = $sensor['x'] - $beacon['x'];
                        $h = $dy + $dx;
                    } //right up
                    else {
                        if ($beacon['y'] > $sensor['y'] && $beacon['x'] > $sensor['x']) {
                            $dy = $beacon['y'] - $sensor['y'];
                            $dx = $beacon['x'] - $sensor['x'];
                            $h = $dy + $dx;
                        } //right down
                        else {
                            if ($beacon['y'] < $sensor['y'] && $beacon['x'] > $sensor['x']) {
                                $dy = $sensor['y'] - $beacon['y'];
                                $dx = $beacon['x'] - $sensor['x'];
                                $h = $dy + $dx;
                            } else {
                                var_dump('error');
                            }
                        }
                    }
                }
            }

            $sensor['h'] = $h;
            $sensors[] = $sensor;
        }

        $line = 10;

        $occupied = [];

        foreach ($sensors as $sensor) {
            if ($sensor['y'] >= $line && ($sensor['y'] - $sensor['h']) <= $line) {
                //line is lower than center ant it's hit
                $edge = $sensor['y'] - $sensor['h'];

                $diff = $line - $edge;

                if ($diff % 2 > 0) {
                    $sides = ($diff - 1);
                } else {
                    $sides = $diff;
                }
                for ($i = 1; $i <= $sides; $i++) {
                    $key = $line . ' ' . ($sensor['x'] + $i);
                    $occupied[$key] = 1;
                    $key = $line . ' ' . ($sensor['x'] - $i);
                    $occupied[$key] = 1;
                }
                $key = $line . ' ' . $sensor['x'];
                $occupied[$key] = 1;

            } elseif ($sensor['y'] <= $line && ($sensor['y'] + $sensor['h']) >= $line) {
                //line is higher than center ant it's hit
                $edge = $sensor['y'] + $sensor['h'];

                $diff = ($edge - $line);

                if ($diff % 2 > 0) {
                    $sides = ($diff - 1);
                } else {
                    $sides = $diff;
                }
                for ($i = 1; $i <= $sides; $i++) {
                    $key = $line . ' ' . ($sensor['x'] + $i);
                    $occupied[$key]++;
                    $key = $line . ' ' . ($sensor['x'] - $i);
                    $occupied[$key]++;
                }

                $key = $line . ' ' . $sensor['x'];
                $occupied[$key] = 1;
            }
        }

        foreach ($beacons as $beacon) {
            if ($beacon['y'] != $line) {
                continue;
            }
            $key = $beacon['y'] . ' ' . $beacon['x'];
            if (isset($occupied[$key])) {
                var_dump($beacon);
                unset($occupied[$key]);
            }
        }

        return count($occupied);

        //4548657 too low
        //5073495 too low
        //5073496 right...
    }

    public function secondPart(string $input)
    {
        $lines = explode("\n", trim($input));

        $sensors = [];
        foreach ($lines as $line) {
            preg_match(
                '/Sensor at x=(?<sensorX>[0-9-]*), y=(?<sensorY>[0-9-]*): closest beacon is at x=(?<beaconX>[0-9-]*), y=(?<beaconY>[0-9-]*)/',
                trim($line),
                $matches
            );
            $sensor = [
                'x' => $matches['sensorX'],
                'y' => $matches['sensorY'],
            ];
            $beacon = [
                'x' => $matches['beaconX'],
                'y' => $matches['beaconY'],
            ];

            if ($sensor['x'] == $beacon['x']) {
                if ($beacon['y'] > $sensor['y']) {
                    $h = $beacon['y'] - $sensor['y'];
                } else {
                    $h = $sensor['y'] - $beacon['y'];
                }
            } elseif ($sensor['y'] == $beacon['y']) {
                if ($beacon['x'] > $sensor['x']) {
                    $h = $beacon['x'] - $sensor['x'];
                } else {
                    $h = $sensor['x'] - $beacon['x'];
                }
            } else {
                //left down
                if ($beacon['y'] < $sensor['y'] && $beacon['x'] < $sensor['x']) {
                    $dy = $sensor['y'] - $beacon['y'];
                    $dx = $sensor['x'] - $beacon['x'];
                    $h = $dy + $dx;
                } //left up
                else {
                    if ($beacon['y'] > $sensor['y'] && $beacon['x'] < $sensor['x']) {
                        $dy = $beacon['y'] - $sensor['y'];
                        $dx = $sensor['x'] - $beacon['x'];
                        $h = $dy + $dx;
                    } //right up
                    else {
                        if ($beacon['y'] > $sensor['y'] && $beacon['x'] > $sensor['x']) {
                            $dy = $beacon['y'] - $sensor['y'];
                            $dx = $beacon['x'] - $sensor['x'];
                            $h = $dy + $dx;
                        } //right down
                        else {
                            if ($beacon['y'] < $sensor['y'] && $beacon['x'] > $sensor['x']) {
                                $dy = $sensor['y'] - $beacon['y'];
                                $dx = $beacon['x'] - $sensor['x'];
                                $h = $dy + $dx;
                            } else {
                                var_dump('error');
                            }
                        }
                    }
                }
            }

            $sensor['h'] = $h;
            $sensors[] = $sensor;
        }

        foreach ($sensors as $key => $sensor) {
            foreach ($this->yieldPerimeter($sensor) as ['x' => $px, 'y' => $py]) {
                $found = false;
                foreach ($sensors as $searchKey => $searchSensor) {
                    if ($key == $searchKey) {
                        continue;
                    }
                    if ($px < 0 || $px > 4000000 || $py < 0 || $py > 4000000) {
                        $found = true;
                        break;
                    }

//                    if ($px < 0 || $px > 20 || $py < 0 || $py > 20) {
//                        $found = true;
//                        break;
//                    }

                    $srx = $searchSensor['x'] + $searchSensor['h'];
                    $slx = $searchSensor['x'] - $searchSensor['h'];

                    $sty = $searchSensor['y'] + $searchSensor['h'];
                    $sdy = $searchSensor['y'] - $searchSensor['h'];


                    if ($px >= $slx && $px <= $srx && $py <= $sty && $py >= $sdy) {
                        if ($py >= $searchSensor['y']) {
                            $edge = $searchSensor['y'] + $searchSensor['h'];
                            $diff = ($edge - $py);
                        } else {
                            $edge = $searchSensor['y'] - $searchSensor['h'];
                            $diff = ($py - $edge);
                        }
                        if ($px <= $searchSensor['x'] + $diff && $px >= $searchSensor['x'] - $diff) {
                            $found = true;
                            break;
                        }
                    }
                }

                if (!$found) {
                    return $px * 4000000 + $py;
                }
            }
        }

        return null;
    }

    public function yieldPerimeter(array $sensor)
    {
        $h = $sensor['h'];
        $x = $sensor['x'];
        $y = $sensor['y'];
        //left to down
        $lx = $x - $h - 1;
        $ly = $y;
        while($lx != $x) {
            yield ['x' => $lx, 'y' => $ly];
            $lx++;
            $ly--;
        }
        //down to right
        $dx = $x;
        $dy = $y - $h -1;
        while($dy != $y) {
            yield ['x' => $dx, 'y' => $dy];
            $dx++;
            $dy++;
        }
        //righ to top
        $rx = $x + $h + 1;
        $ry = $y;
        while($rx != $x) {
            yield ['x' => $rx, 'y' => $ry];
            $rx--;
            $ry++;
        }
        //top to left
        $tx = $x;
        $ty = $y + $h + 1;
        while($ty != $y-1) {
            yield ['x' => $tx, 'y' => $ty];
            $tx--;
            $ty--;
        }
    }
}
