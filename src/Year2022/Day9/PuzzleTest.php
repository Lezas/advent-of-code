<?php

namespace AdventOfCode\Year2022\Day9;

use AdventOfCode\TestInterface;

class PuzzleTest implements TestInterface
{
    public function testFirstPart(): iterable
    {
        yield '13' => <<<INPUT
R 4
U 4
L 3
D 1
R 4
D 1
L 5
R 2
INPUT;
    }
    public function testSecondPart(): iterable
    {
        yield '1' => <<<INPUT
R 4
U 4
L 3
D 1
R 4
D 1
L 5
R 2
INPUT;
        yield '36' => <<<INPUT
R 5
U 8
L 8
D 3
R 17
D 10
L 25
U 20
INPUT;
    }
}
