<?php

namespace AdventOfCode\Year2022;

use AdventOfCode\AbstractDayPuzzleGenerator;

class DayPuzzleGenerator extends AbstractDayPuzzleGenerator
{
    protected function getBaseDir(): string
    {
        return __DIR__;
    }

    protected function getNamespace(): string
    {
        return __NAMESPACE__;
    }
}
