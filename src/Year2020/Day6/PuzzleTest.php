<?php

namespace AdventOfCode\Year2020\Day6;

use AdventOfCode\TestInterface;

class PuzzleTest implements TestInterface
{
    public function testFirstPart(): iterable
    {
        yield '11' => <<<INPUT
abc

a
b
c

ab
ac

a
a
a
a

b
INPUT;
    }

    public function testSecondPart(): iterable
    {
        yield '6' => <<<INPUT
abc

a
b
c

ab
ac

a
a
a
a

b
INPUT;
    }
}