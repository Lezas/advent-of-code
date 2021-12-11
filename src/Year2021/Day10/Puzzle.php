<?php

namespace AdventOfCode\Year2021\Day10;

use AdventOfCode\PuzzleInterface;

class Puzzle implements PuzzleInterface
{
    public function firstPart(string $input)
    {
        $textLines = explode("\n", trim($input));
        $lines = [];

        foreach ($textLines as $line) {
            $lines[] = str_split(trim($line));
        }

        $options = [
            [
                'open' => '(',
                'close' => ')',
            ],
            [
                'open' => '{',
                'close' => '}',
            ],
            [
                'open' => '[',
                'close' => ']',
            ],
            [
                'open' => '<',
                'close' => '>',
            ],
        ];

        $scores = [
            ')' => 3,
            ']' => 57,
            '}' => 1197,
            '>' => 25137,
        ];

        $counts = [
            ')' => 0,
            ']' => 0,
            '}' => 0,
            '>' => 0,
        ];

        foreach ($lines as $line) {
            $openChars = [];
            foreach ($line as $char) {
                if ($this->isOpenChar($char, $options)) {
                    $openChars[] = $char;
                    continue;
                }

                $lastOpen = $openChars[array_key_last($openChars)];

                if (!$this->closeMatches($char, $lastOpen, $options)) {
                    $counts[$char]++;
                    continue 2;
                }

                unset($openChars[array_key_last($openChars)]);
            }
        }
        $sum = 0;
        foreach ($counts as $char => $count) {
            $sum += $scores[$char] * $count;
        }

        return $sum;
    }

    public function secondPart(string $input)
    {
        $textLines = explode("\n", trim($input));
        $lines = [];

        foreach ($textLines as $line) {
            $lines[] = str_split(trim($line));
        }

        $options = [
            [
                'open' => '(',
                'close' => ')',
            ],
            [
                'open' => '{',
                'close' => '}',
            ],
            [
                'open' => '[',
                'close' => ']',
            ],
            [
                'open' => '<',
                'close' => '>',
            ],
        ];

        $scores = [
            ')' => 1,
            ']' => 2,
            '}' => 3,
            '>' => 4,
        ];

        $map = [];
        foreach ($lines as $line) {
            $openChars = [];
            foreach ($line as $char) {
                if ($this->isOpenChar($char, $options)) {
                    $openChars[] = $char;
                    continue;
                }

                $lastOpen = $openChars[array_key_last($openChars)];

                if (!$this->closeMatches($char, $lastOpen, $options)) {
                    continue 2;
                }

                unset($openChars[array_key_last($openChars)]);
            }

            //inconplete line;
            $closeCharacters = [];
            foreach ($openChars as $openChar) {
                foreach ($options as $option) {
                    if ($option['open'] == $openChar) {
                        $closeCharacters[] = $option['close'];
                    }
                }
            }

            $map[] = $closeCharacters;
        }

        $sums = [];

        foreach ($map as $closeCharacters) {
            $sum = 0;
            $closeCharacters = array_reverse($closeCharacters);
            foreach ($closeCharacters as $closeCharacter) {
                $sum = $sum * 5;
                $sum = $sum + $scores[$closeCharacter];
            }
            $sums[] = $sum;
        }

        sort($sums);

        $s = sizeof($sums);

        return $sums[floor($s / 2)];
    }

    private function isOpenChar($char, array $options): bool
    {
        foreach ($options as $option) {
            $optionOpen = $option['open'];
            if ($char == $optionOpen) {
                return true;
            }
        }

        return false;
    }

    private function closeMatches($char, $lastOpen, array $options): bool
    {
        foreach ($options as $option) {
            $optionOpen = $option['open'];
            $optionClose = $option['close'];
            if ($lastOpen == $optionOpen && $char == $optionClose) {
                return true;
            }
        }

        return false;
    }
}