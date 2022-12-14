<?php

namespace AdventOfCode\Year2022\Day2;

use AdventOfCode\TestInterface;

class PuzzleTest implements TestInterface
{
    public function testFirstPart(): iterable
    {
        yield '15' => <<<INPUT
A Y
B X
C Z
INPUT;
    }
    public function testSecondPart(): iterable
    {
        yield '12' => <<<INPUT
A Y
B X
C Z
INPUT;
    }
}
