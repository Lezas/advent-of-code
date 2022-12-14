<?php

namespace AdventOfCode\Year2022\Day14;

use AdventOfCode\TestInterface;

class PuzzleTest implements TestInterface
{
    public function testFirstPart(): iterable
    {
        yield '24' => <<<INPUT
498,4 -> 498,6 -> 496,6
503,4 -> 502,4 -> 502,9 -> 494,9
INPUT;
    }
    public function testSecondPart(): iterable
    {
        yield '93' => <<<INPUT
498,4 -> 498,6 -> 496,6
503,4 -> 502,4 -> 502,9 -> 494,9
INPUT;
    }
}
