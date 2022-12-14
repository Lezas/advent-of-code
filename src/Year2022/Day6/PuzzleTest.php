<?php

namespace AdventOfCode\Year2022\Day6;

use AdventOfCode\TestInterface;

class PuzzleTest implements TestInterface
{
    public function testFirstPart(): iterable
    {
        yield '19' => <<<INPUT
mjqjpqmgbljsphdztnvjfqwrcgsmlb
INPUT;
        yield '6' => <<<INPUT
nppdvjthqldpwncqszvftbrmjlhg
INPUT;
        yield '10' => <<<INPUT
nznrnfrfntjfmvfwmzdfjlvtqnbhcprsg
INPUT;
        yield '11' => <<<INPUT
zcfzfwzzqfrljwzlrfnpqdbhtmscgvjw
INPUT;
    }
    public function testSecondPart(): iterable
    {
        yield '19' => <<<INPUT
mjqjpqmgbljsphdztnvjfqwrcgsmlb
INPUT;
    }
}
