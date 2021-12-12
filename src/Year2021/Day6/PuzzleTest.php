<?php

namespace AdventOfCode\Year2021\Day6;

use AdventOfCode\TestInterface;

class PuzzleTest implements TestInterface
{
    public function testFirstPart(): iterable
    {
        yield '5934' => <<<INPUT
3,4,3,1,2
INPUT;
    }

    public function testSecondPart(): iterable
    {
        yield '26984457539' => <<<INPUT
3,4,3,1,2
INPUT;
    }
}