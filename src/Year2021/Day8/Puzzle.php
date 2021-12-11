<?php

namespace AdventOfCode\Year2021\Day8;

use AdventOfCode\PuzzleInterface;

class Puzzle implements PuzzleInterface
{
    public function firstPart(string $input)
    {
        $fileLines = explode("\n", trim($input));

        $numbers = [];

        foreach ($fileLines as $line) {
            $line = trim(preg_replace('/\s+/', ' ', $line));

            $lines = explode(' | ', $line);
            $line1 = $lines[0];
            $line1 = explode(' ', trim(preg_replace('/\s+/', ' ', $line1)));
            $line2 = $lines[1];
            $line2 = explode(' ', trim(preg_replace('/\s+/', ' ', $line2)));

            $numbers[] = [
                'line1' => $line1,
                'line2' => $line2,
            ];
        }

        $allowedLengths = [7, 4, 2, 3];

        $count = 0;

        foreach ($numbers as $number) {
            $line2 = $number['line2'];
            foreach ($line2 as $item) {
                $length = strlen($item);

                if (in_array($length, $allowedLengths)) {
                    $count++;
                }
            }
        }

        return $count;
    }

    public function secondPart(string $input)
    {
        $fileLines = explode("\n", trim($input));

        $numbers = [];

        foreach ($fileLines as $line) {
                $line = trim(preg_replace('/\s+/', ' ', $line));

                $lines = explode(' | ', $line);
                $line1 = $lines[0];
                $line1 = explode(' ', trim(preg_replace('/\s+/', ' ', $line1)));
                $line2 = $lines[1];
                $line2 = explode(' ', trim(preg_replace('/\s+/', ' ', $line2)));

                $numbers[] = [
                    'line1' => $line1,
                    'line2' => $line2,
                ];
        }

        $sum = 0;

        foreach ($numbers as $number) {
            $line1 = $number['line1'];
            $patternRecognition = $this->getNumbersToLettersMap($line1);

            $line2 = $number['line2'];
            $no = '';
            foreach ($line2 as $item) {
                $no .= $this->getNumber($patternRecognition, $item);
            }

            $sum = $sum + (int)$no;
        }

        return $sum;
    }

    private function getNumber(array $patternRecognition, $item)
    {
        foreach ($patternRecognition as $number => $string) {
            if (strlen($item) !== strlen($string)) {
                continue;
            }
            foreach (str_split($item) as $chars) {
                $string = str_replace($chars, '', $string);
            }

            if (empty($string)) {
                return $number;
            }
        }

        return null;
    }

    private function getNumbersToLettersMap(array $letters): array
    {
        $sixDigitLetters = [];
        $fiveDigitLetters = [];
        $numbers = [
            1 => '',
            2 => '',
            3 => '',
            4 => '',
            5 => '',
            6 => '',
            7 => '',
            8 => '',
            9 => '',
        ];

        foreach ($letters as $number) {
            //number 1
            if (strlen($number) === 2) {
                $numbers[1] = $number;
            }
            //number 7
            if (strlen($number) === 3) {
                $numbers[7] = $number;
            }
            //number 4
            if (strlen($number) === 4) {
                $numbers[4] = $number;
            }
            //number 8
            if (strlen($number) === 7) {
                $numbers[8] = $number;
            }

            if (strlen($number) === 6) {
                $sixDigitLetters[] = $number;
            }

            if (strlen($number) === 5) {
                $fiveDigitLetters[] = $number;
            }
        }

        foreach ($sixDigitLetters as $key => $tmpSixDigitLetter) {
            $full = $tmpSixDigitLetter;
            $chars = str_split($numbers[1]);
            foreach ($chars as $item) {
                $tmpSixDigitLetter = str_replace($item, '', $tmpSixDigitLetter);
            }
            $chars = str_split($numbers[7]);
            foreach ($chars as $item) {
                $tmpSixDigitLetter = str_replace($item, '', $tmpSixDigitLetter);
            }
            $chars = str_split($numbers[4]);
            foreach ($chars as $item) {
                $tmpSixDigitLetter = str_replace($item, '', $tmpSixDigitLetter);
            }

            if (strlen($tmpSixDigitLetter) === 1) {
                $numbers[9] = $full;
                unset($sixDigitLetters[$key]);
            }
        }

        foreach ($fiveDigitLetters as $key => $tmpFiveDigitLetter) {
            $full = $tmpFiveDigitLetter;
            $chars = str_split($numbers[9]);
            foreach ($chars as $item) {
                $tmpFiveDigitLetter = str_replace($item, '', $tmpFiveDigitLetter);
            }
            if (strlen($tmpFiveDigitLetter) === 1) {
                $numbers[2] = $full;
                unset($fiveDigitLetters[$key]);
                break;
            }
        }

        foreach ($fiveDigitLetters as $key => $tmpFiveDigitLetter) {
            $full = $tmpFiveDigitLetter;
            $chars = str_split($numbers[2]);
            foreach ($chars as $item) {
                $tmpFiveDigitLetter = str_replace($item, '', $tmpFiveDigitLetter);
            }
            if (strlen($tmpFiveDigitLetter) === 1) {
                $numbers[3] = $full;
                unset($fiveDigitLetters[$key]);
                break;
            }
        }
        $numbers[5] = reset($fiveDigitLetters);

        foreach ($sixDigitLetters as $key => $tmpSixDigitLetter) {
            $full = $tmpSixDigitLetter;
            $chars = str_split($numbers[7]);
            foreach ($chars as $item) {
                $tmpSixDigitLetter = str_replace($item, '', $tmpSixDigitLetter);
            }

            if (strlen($tmpSixDigitLetter) === 3) {
                $numbers[0] = $full;
                unset($sixDigitLetters[$key]);
            }
        }


        $numbers[6] = reset($sixDigitLetters);

        return $numbers;
    }
}