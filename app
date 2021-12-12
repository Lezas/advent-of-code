#!/usr/bin/env php
<?php

require __DIR__.'/vendor/autoload.php';

use AdventOfCode\Command\DownloadPuzzleInputCommand;
use AdventOfCode\Command\GenerateDayPuzzleCommand;
use AdventOfCode\Command\RunDayPuzzleCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Dotenv\Dotenv;

$application = new Application();

$application->add(new RunDayPuzzleCommand());
$application->add(new GenerateDayPuzzleCommand());
$application->add(new DownloadPuzzleInputCommand());

$dotenv = new Dotenv();
$dotenv->load(__DIR__.'/.env');

$application->run();