<?php

namespace AdventOfCode\Year2021\Day16;

use AdventOfCode\PuzzleInterface;

class Puzzle implements PuzzleInterface
{
    private $headPosition = 0;
    private $versionSum = 0;
    const HEX_TO_BIN = [
        '0' => '0000',
        '1' => '0001',
        '2' => '0010',
        '3' => '0011',
        '4' => '0100',
        '5' => '0101',
        '6' => '0110',
        '7' => '0111',
        '8' => '1000',
        '9' => '1001',
        'A' => '1010',
        'B' => '1011',
        'C' => '1100',
        'D' => '1101',
        'E' => '1110',
        'F' => '1111',
    ];

    public function firstPart(string $input): string
    {
        $binary = [];
        foreach (str_split($input) as $hex) {
            $bin = self::HEX_TO_BIN[$hex];
            foreach (str_split($bin) as $item) {
                $binary[] = $item;
            }
        }

        $this->parse($binary);

        return $this->versionSum;
    }

    public function secondPart(string $input): string
    {
        $binary = [];
        foreach (str_split($input) as $hex) {
            $bin = self::HEX_TO_BIN[$hex];
            foreach (str_split($bin) as $item) {
                $binary[] = $item;
            }
        }

        return $this->parse($binary);
    }

    private function parse(array $binary)
    {
        //get version
        $versionBin = '';
        $versionBin .= $binary[$this->headPosition++];
        $versionBin .= $binary[$this->headPosition++];
        $versionBin .= $binary[$this->headPosition++];

        $versionDec = bindec($versionBin);
        $this->versionSum += $versionDec;
        //get type
        $typeBin = $binary[$this->headPosition++]
            . $binary[$this->headPosition++]
            . $binary[$this->headPosition++];

        $typeDec = bindec($typeBin);

        if ($typeDec === 4) {
            $foundedAllBits = false;
            $numberBin = '';
            while ($foundedAllBits === false) {
                $groupLeadingBit = $binary[$this->headPosition++];
                if ($groupLeadingBit == 0) {
                    $foundedAllBits = true;
                }
                $numberBin .= $binary[$this->headPosition++]
                    . $binary[$this->headPosition++]
                    . $binary[$this->headPosition++]
                    . $binary[$this->headPosition++];
            }
            $numberDec = bindec($numberBin);

            return $numberDec;
        } else {
            $lengthTypeID = $binary[$this->headPosition++];

            if ($lengthTypeID == 0) {
                $lengthBin = '';

                $i = 1;
                while ($i++ <= 15) {
                    $lengthBin .= $binary[$this->headPosition++];
                }
                $lengthDec = bindec($lengthBin);

                $maxHead = $this->headPosition + $lengthDec;
                $values = [];
                //parse only next $lengthDec bits only
                while ($this->headPosition < $maxHead) {
                    $values[] = $this->parse($binary);
                }

                return $this->doOperation($typeDec, $values);
            } else {
                $lengthBin = '';

                $i = 1;
                while ($i++ <= 11) {
                    $lengthBin .= $binary[$this->headPosition++];
                }
                $lengthDec = bindec($lengthBin);
                //parse $lengthDec times
                $values = [];
                for ($i = 1; $i <= $lengthDec; $i++) {
                    $values[] = $this->parse($binary);
                }

                return $this->doOperation($typeDec, $values);
            }
        }
    }

    public function doOperation($operationId, array $values)
    {
        switch ($operationId) {
            case 0:
                return array_sum($values);
            case 1:
                return array_product($values);
            case 2:
                return min($values);
            case 3:
                return max($values);
            case 5:
                return (int)($values[0] > $values[1]);
            case 6:
                return (int)($values[0] < $values[1]);
            case 7:
                return (int)($values[0] == $values[1]);
            default:
                throw new \Exception('undefined operation: ' . $operationId . PHP_EOL);
        }
    }
}
