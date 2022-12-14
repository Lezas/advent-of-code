<?php

namespace AdventOfCode\Year2022\Day8;

use AdventOfCode\TestInterface;

class PuzzleTest implements TestInterface
{
    public function testFirstPart(): iterable
    {
        yield '21' => <<<INPUT
30373
25512
65332
33549
35390
INPUT;
    }
    public function testSecondPart(): iterable
    {
        yield '8' => <<<INPUT
30373
25512
65332
33549
35390
INPUT;
    }
}
