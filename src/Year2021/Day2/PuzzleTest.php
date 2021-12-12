<?php

namespace AdventOfCode\Year2021\Day2;

use AdventOfCode\TestInterface;

class PuzzleTest implements TestInterface
{
    public function testFirstPart(): iterable
    {
        yield '150' => <<<INPUT
forward 5
down 5
forward 8
up 3
down 8
forward 2
INPUT;
    }
    public function testSecondPart(): iterable
    {
        yield '900' => <<<INPUT
forward 5
down 5
forward 8
up 3
down 8
forward 2
INPUT;
    }
}