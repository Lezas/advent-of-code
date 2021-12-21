<?php

namespace AdventOfCode\Year2021\Day21;

use AdventOfCode\TestInterface;

class PuzzleTest implements TestInterface
{
    public function testFirstPart(): iterable
    {
        yield '739785' => <<<INPUT
Player 1 starting position: 4
Player 2 starting position: 8
INPUT;
        yield '920580' => <<<INPUT
Player 1 starting position: 6
Player 2 starting position: 4
INPUT;
    }

    public function testSecondPart(): iterable
    {
        yield '444356092776315' => <<<INPUT
Player 1 starting position: 4
Player 2 starting position: 8
INPUT;
        yield '647920021341197' => <<<INPUT
Player 1 starting position: 6
Player 2 starting position: 4
INPUT;
    }
}
