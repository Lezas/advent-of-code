<?php

namespace AdventOfCode\Year2022\Day7;

use AdventOfCode\PuzzleInterface;

class Puzzle implements PuzzleInterface
{
    public function firstPart(string $input)
    {
        $lines = explode("\n", trim($input));
        $map = [];

        $mode = null;
        /** @var \Directory $currentDirectory */
        $currentDirectory = null;
        $rootDir = null;
        foreach ($lines as $line) {
            if ($line[0] === '$') {
                //this is command input
                preg_match('/\$ (?<command>[a-z]*)/', $line, $matches);
                $commandName = $matches['command'];

                switch ($commandName) {
                    case 'cd' :
                        preg_match('/\$ (?<command>[a-z]*) (?<name>[a-z\/.]*)/', $line, $matches);
                        if ($matches['name'] == '..') {
                            $currentDirectory = $currentDirectory->parentDirectory;
                            continue;
                        }
                        $name = $matches['name'];
                        if (null !== $currentDirectory && null !== $currentDirectory->directories[$name]) {
                            $currentDirectory = $currentDirectory->directories[$name];
                            continue;
                        }
                        $directory = new Directory();
                        $directory->name = $matches['name'];
                        if (null === $currentDirectory) {
                            $currentDirectory = $directory;
                            $rootDir = $directory;
                        } else {
                            //in perfect solution and - unreachable
                            exit();
                            $currentDirectory->directories[$matches['name']] = $directory;
                            $currentDirectory = $directory;
                        }
                        break;
                    case 'ls' :
                        continue;
                        break;
                }
                continue;
            }

            preg_match('/(?<par1>[a-z0-9]*) (?<par2>[a-z.]*)/', $line, $matches);

            if ($matches['par1'] == 'dir') {
                $directory = new Directory();
                $directory->name = $matches['par2'];
                $directory->parentDirectory = $currentDirectory;
                $currentDirectory->directories[$matches['par2']] = $directory;
                continue;
            }

            $currentDirectory->files[] = ['fileName' => $matches['par2'], 'size' => $matches['par1']];
            $this->addSize($currentDirectory, $matches['par1']);
        }

        //puzzle 1 solution:
//        return $this->sumSizes($rootDir, 0);

        $freeSpace = 70000000 - $rootDir->folderSize;

        $left = 30000000 - $freeSpace;
        return $this->findLowestSize($rootDir, 99999999999999, $left);
    }

    public function findLowestSize(Directory $directory, int $size, int $leftToEnough)
    {
        if ($directory->folderSize >= $leftToEnough && $directory->folderSize < $size) {
            $size = $directory->folderSize;
        }

        foreach ($directory->directories as $subDirectory) {
            $size = $this->findLowestSize($subDirectory, $size, $leftToEnough);
        }

        return $size;
    }

    public function sumSizes(Directory $directory, int $size)
    {
        if ($directory->folderSize < 100000) {
            $size += $directory->folderSize;
        }

        foreach ($directory->directories as $subDirectory) {
            $size = $this->sumSizes($subDirectory, $size);
        }

        return $size;
    }

    public function addSize(Directory $directory, int $size)
    {
        $directory->folderSize += $size;
        if ($directory->parentDirectory !== null) {
            $this->addSize($directory->parentDirectory, $size);
        }
    }

    public function secondPart(string $input)
    {
        $lines = explode("\n", trim($input));
        $map = [];

        foreach ($lines as $line) {
            $map[] = trim($line);
            //modify each line according to your needs
        }

        //Logic goes here
        $result = 0;

        return $result;
    }
}

class directory
{
    public $folderSize = 0;
    public $name;
    public $files = [];
    public $directories = [];
    public $parentDirectory = null;
}
