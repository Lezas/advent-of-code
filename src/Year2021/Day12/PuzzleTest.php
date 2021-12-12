<?php

namespace AdventOfCode\Year2021\Day12;

use AdventOfCode\TestInterface;

class PuzzleTest implements TestInterface
{
    public function testFirstPart(): iterable
    {
        yield '19' => <<<INPUT
dc-end
HN-start
start-kj
dc-start
dc-HN
LN-dc
HN-end
kj-sa
kj-HN
kj-dc
INPUT;
        yield '10' => <<<INPUT
start-A
start-b
A-c
A-b
b-d
A-end
b-end
INPUT;
        yield '226' => <<<INPUT
fs-end
he-DX
fs-he
start-DX
pj-DX
end-zg
zg-sl
zg-pj
pj-he
RW-he
fs-DX
pj-RW
zg-RW
start-pj
he-WI
zg-he
pj-fs
start-RW
INPUT;
    }

    public function testSecondPart(): iterable
    {
        yield '36' => <<<INPUT
start-A
start-b
A-c
A-b
b-d
A-end
b-end
INPUT;
        yield '103' => <<<INPUT
dc-end
HN-start
start-kj
dc-start
dc-HN
LN-dc
HN-end
kj-sa
kj-HN
kj-dc
INPUT;
        yield '3509' => <<<INPUT
fs-end
he-DX
fs-he
start-DX
pj-DX
end-zg
zg-sl
zg-pj
pj-he
RW-he
fs-DX
pj-RW
zg-RW
start-pj
he-WI
zg-he
pj-fs
start-RW
INPUT;
    }
}