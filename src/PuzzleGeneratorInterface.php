<?php

namespace AdventOfCode;

interface PuzzleGeneratorInterface
{
    public function generateDay(int $day, bool $force = false);

    public function populateInputFile(int $day, string $content): void;
}