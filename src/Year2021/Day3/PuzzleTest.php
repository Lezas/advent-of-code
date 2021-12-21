<?php

namespace AdventOfCode\Year2021\Day3;

use AdventOfCode\TestInterface;

class PuzzleTest implements TestInterface
{
    public function testFirstPart(): iterable
    {
        yield '198' => <<<INPUT
00100
11110
10110
10111
10101
01111
00111
11100
10000
11001
00010
01010
INPUT;
    }
    public function testSecondPart(): iterable
    {
        yield '230' => <<<INPUT
00100
11110
10110
10111
10101
01111
00111
11100
10000
11001
00010
01010
INPUT;
    }
}
