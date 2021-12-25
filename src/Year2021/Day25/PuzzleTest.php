<?php

namespace AdventOfCode\Year2021\Day25;

use AdventOfCode\TestInterface;

class PuzzleTest implements TestInterface
{
    public function testFirstPart(): iterable
    {
        yield '58' => <<<INPUT
v...>>.vv>
.vv>>.vv..
>>.>v>...v
>>v>>.>.v.
v>v.vv.v..
>.>>..v...
.vv..>.>v.
v.v..>>v.v
....v..v.>
INPUT;
    }
    public function testSecondPart(): iterable
    {
        yield 'Win!' => <<<INPUT
INPUT;
    }
}