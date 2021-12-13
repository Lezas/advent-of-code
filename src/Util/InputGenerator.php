<?php

namespace AdventOfCode\Util;

class InputGenerator
{
    public static function inputToLineGenerator(string $input): \Generator
    {
        yield from explode("\n", trim($input));
    }
}
