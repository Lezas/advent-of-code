<?php

namespace AdventOfCode\Year2021\Day1;

use AdventOfCode\TestInterface;

class PuzzleTest implements TestInterface
{
    public function testFirstPart(): iterable
    {
        yield '7' => <<<INPUT
199
200
208
210
200
207
240
269
260
263
INPUT;
    }
    public function testSecondPart(): iterable
    {
        yield '5' => <<<INPUT
199
200
208
210
200
207
240
269
260
263
INPUT;
    }
}