<?php

namespace AdventOfCode\Year2020\Day1;

use AdventOfCode\TestInterface;

class PuzzleTest implements TestInterface
{
    public function testFirstPart(): iterable
    {
        yield '514579' => <<<INPUT
1721
979
366
299
675
1456
INPUT;
    }
    public function testSecondPart(): iterable
    {
        yield '241861950' => <<<INPUT
1721
979
366
299
675
1456
INPUT;
    }
}