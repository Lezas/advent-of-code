<?php

namespace AdventOfCode\Year2021\Day11;

use AdventOfCode\TestInterface;

class PuzzleTest implements TestInterface
{
    public function testFirstPart(): iterable
    {
        yield '1656' => <<<INPUT
5483143223
2745854711
5264556173
6141336146
6357385478
4167524645
2176841721
6882881134
4846848554
5283751526
INPUT;
    }
    public function testSecondPart(): iterable
    {
        yield '195' => <<<INPUT
5483143223
2745854711
5264556173
6141336146
6357385478
4167524645
2176841721
6882881134
4846848554
5283751526
INPUT;
    }
}