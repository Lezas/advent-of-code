<?php

namespace AdventOfCode\Year2021\Day15;

use AdventOfCode\TestInterface;

class PuzzleTest implements TestInterface
{
    public function testFirstPart(): iterable
    {
        yield '40' => <<<INPUT
1163751742
1381373672
2136511328
3694931569
7463417111
1319128137
1359912421
3125421639
1293138521
2311944581
INPUT;
    }
    public function testSecondPart(): iterable
    {
        yield '315' => <<<INPUT
1163751742
1381373672
2136511328
3694931569
7463417111
1319128137
1359912421
3125421639
1293138521
2311944581
INPUT;
    }
}