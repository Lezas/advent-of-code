<?php

namespace AdventOfCode\Year2021\Day4;

use AdventOfCode\PuzzleInterface;

class Puzzle implements PuzzleInterface
{
    public function firstPart(string $input)
    {
        $lines = explode("\n", trim($input));

        $firstLine = array_shift($lines);
        $numbers = explode(',', $firstLine);

        //empty line
        array_shift($lines);

        $boards = [];

        $board = new Board();

        $boards[] = $board;

        foreach ($lines as $line) {
            preg_match(
                '/(?<first>[0-9]+) +(?<second>[0-9]+) +(?<third>[0-9]+) +(?<fourth>[0-9]+) +(?<fifth>[0-9]+)/',
                $line,
                $matches
            );

            if (empty($matches)) {
                //bingo board completed

                $board = new Board();
                $boards[] = $board;

                continue;
            }

            $board->addLine($matches);
        }

        $winnerBoard = null;

        foreach ($boards as $board) {
            foreach ($numbers as $number) {
                $board->addNumber((int)$number);

                if ($board->bingo) {
                    if ($winnerBoard === null) {
                        $winnerBoard = $board;
                    } else {
                        if ($board->numbersAdded < $winnerBoard->numbersAdded) {
                            $winnerBoard = $board;
                        }
                    }

                    continue 2;
                }
            }
        }

        $sum = 0;
        foreach ($winnerBoard->columns as $column) {
            foreach ($column->cells as $cell) {
                if ($cell->marked === false) {
                    $sum += $cell->number;
                }
            }
        }

        return $winnerBoard->bingoLastNumber * $sum;
    }

    public function secondPart(string $input)
    {

        $lines = explode("\n", trim($input));

        $firstLine = array_shift($lines);
        $numbers = explode(',', $firstLine);

        //empty line
        array_shift($lines);

        $boards = [];

        $board = new Board();

        $boards[] = $board;

        foreach ($lines as $line) {
            preg_match(
                '/(?<first>[0-9]+) +(?<second>[0-9]+) +(?<third>[0-9]+) +(?<fourth>[0-9]+) +(?<fifth>[0-9]+)/',
                $line,
                $matches
            );

            if (empty($matches)) {
                //bingo board completed

                $board = new Board();
                $boards[] = $board;

                continue;
            }

            $board->addLine($matches);
        }

        $winnerBoard = null;

        foreach ($boards as $board) {
            foreach ($numbers as $number) {
                $board->addNumber((int)$number);

                if ($board->bingo) {
                    if ($winnerBoard === null) {
                        $winnerBoard = $board;


                    } else {
                        if ($board->numbersAdded > $winnerBoard->numbersAdded) {
                            $winnerBoard = $board;
                        }
                    }

                    continue 2;
                }
            }
        }

        $sum = 0;
        foreach ($winnerBoard->columns as $column) {
            foreach ($column->cells as $cell) {
                if ($cell->marked === false) {
                    $sum += $cell->number;
                }
            }
        }

        return $winnerBoard->bingoLastNumber * $sum;
    }
}

class Board
{
    /** @var array|Row */
    public $lines = [];

    public $columns = [];
    /** @var bool */
    public $bingo = false;

    public $bingoLastNumber;

    public $numbersAdded = 0;

    public function __construct()
    {
        $this->columns = [
            0 => new Row(),
            1 => new Row(),
            2 => new Row(),
            3 => new Row(),
            4 => new Row(),
        ];
    }

    public function addLine(array $array)
    {
        $this->lines[] = Row::fromArray($array);

        $this->columns[0]->addCell(new Cell($array['first']));
        $this->columns[1]->addCell(new Cell($array['second']));
        $this->columns[2]->addCell(new Cell($array['third']));
        $this->columns[3]->addCell(new Cell($array['fourth']));
        $this->columns[4]->addCell(new Cell($array['fifth']));
    }

    public function addNumber(int $number)
    {
        if ($this->bingo) {
            return false;
        }

        $this->numbersAdded++;
        /** @var Row $line */
        foreach ($this->lines as $line) {
            $line->addNumber($number);
            if ($line->fullyMarked) {
                $this->bingo = true;
                $this->bingoLastNumber = $number;
            }
        }
        /** @var Row $line */
        foreach ($this->columns as $line) {
            $line->addNumber($number);
            if ($line->fullyMarked) {
                $this->bingo = true;
                $this->bingoLastNumber = $number;
            }
        }

        return true;
    }
}

class Row
{
    /** @var array|Cell[] */
    public $cells = [];

    public $fullyMarked = false;

    public function addCell(Cell $cell)
    {
        $this->cells[] = $cell;
    }

    public static function fromArray(array $array): Row
    {
        $row = new Row();
        $row->addCell(new Cell($array['first']));
        $row->addCell(new Cell($array['second']));
        $row->addCell(new Cell($array['third']));
        $row->addCell(new Cell($array['fourth']));
        $row->addCell(new Cell($array['fifth']));

        return $row;
    }

    public function addNumber(int $number)
    {
        foreach ($this->cells as $cell) {
            if ($cell->number == $number) {
                $cell->marked = true;
                $this->evaluateBingo();
            }
        }
    }

    public function evaluateBingo()
    {
        foreach ($this->cells as $cell) {
            if ($cell->marked === false) {
                return;
            }
        }

        $this->fullyMarked = true;
    }
}

class Cell
{
    public $number;
    public $marked = false;

    public function __construct(int $number)
    {
        $this->number = $number;
    }
}