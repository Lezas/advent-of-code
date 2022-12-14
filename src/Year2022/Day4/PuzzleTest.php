<?php

namespace AdventOfCode\Year2022\Day4;

use AdventOfCode\TestInterface;

class PuzzleTest implements TestInterface
{
    public function testFirstPart(): iterable
    {
        yield '2' => <<<INPUT
2-4,6-8
2-3,4-5
5-7,7-9
2-8,3-7
6-6,4-6
2-6,4-8
INPUT;
    }
    public function testSecondPart(): iterable
    {
        yield '4' => <<<INPUT
2-4,6-8
2-3,4-5
5-7,7-9
2-8,3-7
6-6,4-6
2-6,4-8
INPUT;
    }
}
