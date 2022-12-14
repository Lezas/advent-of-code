<?php

namespace AdventOfCode\Year2022\Day12;

use AdventOfCode\TestInterface;

class PuzzleTest implements TestInterface
{
    public function testFirstPart(): iterable
    {
        yield '31' => <<<INPUT
Sabqponm
abcryxxl
accszExk
acctuvwj
abdefghi
INPUT;
    }
    public function testSecondPart(): iterable
    {
        yield '29' => <<<INPUT
Sabqponm
abcryxxl
accszExk
acctuvwj
abdefghi
INPUT;
    }
}
