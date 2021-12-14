<?php

namespace AdventOfCode\Year2021\Day14;

use AdventOfCode\TestInterface;

class PuzzleTest implements TestInterface
{
    public function testFirstPart(): iterable
    {
        yield '1588' => <<<INPUT
NNCB

CH -> B
HH -> N
CB -> H
NH -> C
HB -> C
HC -> B
HN -> C
NN -> C
BH -> H
NC -> B
NB -> B
BN -> B
BB -> N
BC -> B
CC -> N
CN -> C
INPUT;
    }

    public function testSecondPart(): iterable
    {
        yield '2188189693529' => <<<INPUT
NNCB

CH -> B
HH -> N
CB -> H
NH -> C
HB -> C
HC -> B
HN -> C
NN -> C
BH -> H
NC -> B
NB -> B
BN -> B
BB -> N
BC -> B
CC -> N
CN -> C
INPUT;
    }
}

