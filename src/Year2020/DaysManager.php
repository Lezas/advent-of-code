<?php

namespace AdventOfCode\Year2020;

use AdventOfCode\AbstractDaysManager;

class DaysManager extends AbstractDaysManager
{
    public static function getNamespace(): string
    {
        return __NAMESPACE__;
    }

    public static function getBaseDir(): string
    {
        return __DIR__;
    }
}