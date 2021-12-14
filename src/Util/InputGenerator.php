<?php

namespace AdventOfCode\Util;

class InputGenerator
{
    public static function inputToLineGenerator(string $input): \Generator
    {
        yield from preg_split("/\R/", trim($input));
    }
}
