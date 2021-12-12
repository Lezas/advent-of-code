<?php

namespace AdventOfCode\Year2021\Day9;

use AdventOfCode\TestInterface;

class PuzzleTest implements TestInterface
{
    public function testFirstPart(): iterable
    {
        yield '15' => <<<INPUT
2199943210
3987894921
9856789892
8767896789
9899965678
INPUT;
    }
    public function testSecondPart(): iterable
    {
        yield '1134' => <<<INPUT
2199943210
3987894921
9856789892
8767896789
9899965678
INPUT;
    }
}