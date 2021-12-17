<?php

namespace AdventOfCode\Year2021\Day17;

use AdventOfCode\TestInterface;

class PuzzleTest implements TestInterface
{
    public function testFirstPart(): iterable
    {
        yield '45' => <<<INPUT
target area: x=20..30, y=-10..-5
INPUT;
//        yield '7750' => <<<INPUT
//target area: x=138..184, y=-125..-71
//INPUT;
    }
    public function testSecondPart(): iterable
    {
        yield '112' => <<<INPUT
target area: x=20..30, y=-10..-5
INPUT;
//        yield '4120' => <<<INPUT
//target area: x=138..184, y=-125..-71
//INPUT;
    }
}
