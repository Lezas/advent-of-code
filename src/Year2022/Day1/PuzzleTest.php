<?php

namespace AdventOfCode\Year2022\Day1;

use AdventOfCode\TestInterface;

class PuzzleTest implements TestInterface
{
    public function testFirstPart(): iterable
    {
        yield '7' => <<<INPUT
1000
2000
3000

4000

5000
6000

7000
8000
9000

10000
INPUT;
    }
    public function testSecondPart(): iterable
    {
        yield '5' => <<<INPUT
1000
2000
3000

4000

5000
6000

7000
8000
9000

10000
INPUT;
    }
}
