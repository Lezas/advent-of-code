#!/usr/bin/env php
<?php

require __DIR__.'/vendor/autoload.php';

use AdventOfCode\DownloadPuzzleInputCommand;
use AdventOfCode\GenerateDayPuzzleCommand;
use AdventOfCode\RunDayPuzzleCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Dotenv\Dotenv;

$application = new Application();

$application->add(new RunDayPuzzleCommand());
$application->add(new GenerateDayPuzzleCommand());
$application->add(new DownloadPuzzleInputCommand());

$dotenv = new Dotenv();
$dotenv->load(__DIR__.'/.env');

$application->run();