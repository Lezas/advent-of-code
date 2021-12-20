<?php

namespace AdventOfCode\Year2021\Day20;

use AdventOfCode\PuzzleInterface;

class Puzzle implements PuzzleInterface
{
    public function firstPart(string $input)
    {
        [$algorithm, $imageString] = preg_split("|\R\R|", trim($input));
        $image = [];

        $algorithm = str_split($algorithm);

        foreach (preg_split("|\R|", $imageString) as $line) {
            $image[] = str_split($line);
        }
        $imageHeight = count($image);
        $imageLength = count($image[0]);
        $newImageHeight = $imageHeight + 8;
        $newImageLength = $imageLength + 8;

        $newImage = [];

        for ($iHeight = 0; $iHeight < $newImageHeight; $iHeight++) {
            $line = [];
            for ($iLength = 0; $iLength < $newImageLength; $iLength++) {
                $searchHeightI = $iHeight - 4;
                $searchLengthI = $iLength - 4;

                if (!isset($image[$searchHeightI])) {
                    $line[] = '.';
                    continue;
                }
                if (!isset($image[$searchHeightI][$searchLengthI])) {
                    $line[] = '.';
                    continue;
                }

                $line[] = $image[$searchHeightI][$searchLengthI];
            }
            $newImage[] = $line;
        }
        $image = $newImage;

        $steps = 2;
        for ($i = 1; $i <= $steps; $i++) {
            $newImage = [];
            $imageHeight = count($image) - $i;
            $imageLength = count($image[0]) - $i;

            for ($iHeight = 0; $iHeight < $imageHeight; $iHeight++) {
                $line = [];
                for ($iLength = 0; $iLength < $imageLength; $iLength++) {
                    $searchLine = $this->getSearchLine($image, $iHeight, $iLength);
                    $searchKey = bindec(str_replace(['.', '#'], ['0', '1'], $searchLine));
                    $newChar = $algorithm[$searchKey];
                    $line[] = $newChar;
                }
                $newImage[] = $line;
            }
            $image = $newImage;
        }

        $count = 0;
        foreach ($image as $line) {
            foreach ($line as $char) {
                if ($char == '#') {
                    $count++;
                }
            }
        }

        return $count;
    }

    public function secondPart(string $input)
    {
        [$algorithm, $imageString] = preg_split("|\R\R|", trim($input));
        $image = [];

        $algorithm = str_split($algorithm);

        foreach (preg_split("|\R|", $imageString) as $line) {
            $image[] = str_split($line);
        }
        $imageHeight = count($image);
        $imageLength = count($image[0]);
        $addition = 400;
        $newImageHeight = $imageHeight + $addition;
        $newImageLength = $imageLength + $addition;

        $newImage = [];

        for ($iHeight = 0; $iHeight < $newImageHeight; $iHeight++) {
            $line = [];
            for ($iLength = 0; $iLength < $newImageLength; $iLength++) {
                $searchHeightI = $iHeight - (int)($addition / 2);
                $searchLengthI = $iLength - (int)($addition / 2);

                if (!isset($image[$searchHeightI])) {
                    $line[] = '.';
                    continue;
                }
                if (!isset($image[$searchHeightI][$searchLengthI])) {
                    $line[] = '.';
                    continue;
                }

                $line[] = $image[$searchHeightI][$searchLengthI];
            }
            $newImage[] = $line;
        }
        $image = $newImage;

        $steps = 50;
        while ($steps--) {
            $newImage = [];
            $imageHeight = count($image) - 1;
            $imageLength = count($image[0]) - 1;

            for ($iHeight = 0; $iHeight < ($imageHeight - 1); $iHeight++) {
                $line = [];
                for ($iLength = 0; $iLength < ($imageLength - 1); $iLength++) {
                    $searchHeightI = $iHeight + 1;
                    $searchLengthI = $iLength + 1;

                    $addition = [-1, 0, 1];
                    $key = '';

                    foreach ($addition as $heightAddition) {
                        foreach ($addition as $lengthAddition) {
                            if (!isset($image[$searchHeightI + $heightAddition])) {
                                continue;
                            }
                            if (!isset($image[$searchHeightI + $heightAddition][$searchLengthI + $lengthAddition])) {
                                continue;
                            }
                            $key .= $image[$searchHeightI + $heightAddition][$searchLengthI + $lengthAddition];
                        }
                    }

                    $searchKey = bindec(str_replace(['.', '#'], ['0', '1'], $key));
                    $newChar = $algorithm[$searchKey];
                    $line[] = $newChar;
                }
                $newImage[] = $line;
            }
            $image = $newImage;
        }

        $count = 0;
        foreach ($image as $line) {
            foreach ($line as $char) {
                if ($char == '#') {
                    $count++;
                }
            }
        }

        return $count;
    }

    private function getSearchLine(array $image, int $iHeight, int $iLength): string
    {
        $searchHeightI = $iHeight + 1;
        $searchLengthI = $iLength + 1;

        $addition = [-1, 0, 1];
        $key = '';

        foreach ($addition as $heightAddition) {
            foreach ($addition as $lengthAddition) {
                if (!isset($image[$searchHeightI + $heightAddition])) {
                    $key .= '.';
                    continue;
                }
                if (!isset($image[$searchHeightI + $heightAddition][$searchLengthI + $lengthAddition])) {
                    $key .= '.';
                    continue;
                }
                $key .= $image[$searchHeightI + $heightAddition][$searchLengthI + $lengthAddition];
            }
        }

        return $key;
    }
}
