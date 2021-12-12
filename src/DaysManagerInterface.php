<?php

namespace AdventOfCode;

interface DaysManagerInterface
{
    public function runDayPuzzle(int $day, string $part, ?string $input = null);

    public function getTests(int $day, string $part): iterable;
}