<?php

namespace AdventOfCode\Year2021\Day18;

use AdventOfCode\PuzzleInterface;

class Puzzle implements PuzzleInterface
{
    public function firstPart(string $input)
    {
        $lines = [];

        foreach (explode("\n", trim($input)) as $line) {
            $chars = str_split(trim($line));
            $firstCharacter = array_shift($chars);
            if ($firstCharacter != '[') {
                throw new \Exception('I should have found here an opening character');
            }
            $node = new Node();
            $this->stringToNodes($chars, $node);

            $lines[] = $node;
        }

        $firstNode = $lines[0];

        $count = count($lines);
        for ($i = 1; $i < $count; $i++) {
            $secondNode = $lines[$i];
            $node = new Node();
            $node->left = $firstNode;
            $node->right = $secondNode;

            $secondNode->parent = $firstNode->parent = $node;
            $this->performActions($node);

            $firstNode = $node;
        }

        return $this->calculateMagnitude($firstNode);
    }

    private function calculateMagnitude(Node $node): int
    {
        if ($node->right instanceof Node) {
            $secondOperand = $this->calculateMagnitude($node->right) * 2;
        } else {
            $secondOperand = $node->right * 2;
        }
        if ($node->left instanceof Node) {
            $thirdOperand = $this->calculateMagnitude($node->left) * 3;
        } else {
            $thirdOperand = $node->left * 3;
        }

        return $secondOperand + $thirdOperand;
    }

    private function performActions(Node $node)
    {
        do {
            $doneAction = false;
            do {
                //explodeTheNode method will explode multiple times.
                $exploded = $this->explodeTheNode($node);
                if ($this->explodeTheNode($node)) {
                    $doneAction = true;
                }
            } while ($exploded);

            //splitNodes method will perform only single split. Since after any action, explode should be performed
            if ($this->splitNodes($node)) {
                $doneAction = true;
            }
        } while ($doneAction);
    }

    private function splitNodes(Node $node): bool
    {
        $leftNode = $node->left;
        if ($leftNode instanceof Node) {
            $splitLeft = $this->splitNodes($leftNode);
            if ($splitLeft) {
                return true;
            }
        } elseif ($leftNode >= 10) {
            $newNode = new Node();
            $newNode->left = (int)floor($leftNode / 2);
            $newNode->right = (int)ceil($leftNode / 2);

            $newNode->parent = $node;
            $node->left = $newNode;

            return true;
        }

        $rightNode = $node->right;
        if ($rightNode instanceof Node) {
            $splitRight = $this->splitNodes($rightNode);
            if ($splitRight) {
                return true;
            }
        } elseif ($rightNode >= 10) {
            $newNode = new Node();
            $newNode->left = (int)floor($rightNode / 2);
            $newNode->right = (int)ceil($rightNode / 2);

            $newNode->parent = $node;
            $node->right = $newNode;

            return true;
        }

        return false;
    }

    private function printNode(Node $node)
    {
        $returnString = '[';
        if ($node->left instanceof Node) {
            $returnString .= $this->printNode($node->left);
        } else {
            $returnString .= $node->left;
        }
        $returnString .= ',';

        if ($node->right instanceof Node) {
            $returnString .= $this->printNode($node->right);
        } else {
            $returnString .= $node->right;
        }
        $returnString .= ']';

        return $returnString;
    }

    private function explodeTheNode(Node $node, $pairCount = 0)
    {
        if ($pairCount == 4) {
            if ($node->right instanceof Node) {
                throw new \Exception('I should have found here an number');
            }
            if ($node->left instanceof Node) {
                throw new \Exception('I should have found here an number');
            }
            $leftNumber = $node->left;
            $rightNumber = $node->right;
            $this->addToNextLeftNumber($node->parent, $node, $leftNumber);
            $this->addToNextRightNumber($node->parent, $node, $rightNumber);
            if ($node->parent->left === $node) {
                $node->parent->left = 0;
            } else {
                $node->parent->right = 0;
            }

            return true;
        }
        $explodedLeft = false;
        if ($node->left instanceof Node) {
            $explodedLeft = $this->explodeTheNode($node->left, $pairCount + 1);
        }
        $explodedRight = false;
        if ($node->right instanceof Node) {
            $explodedRight = $this->explodeTheNode($node->right, $pairCount + 1);
        }

        return $explodedRight || $explodedLeft;
    }

    private function addToNextLeftNumber(Node $node, Node $callingNode, int $number)
    {
        if ($node->left === $callingNode) {
            if ($node->parent === null) {
                return;
            }

            $this->addToNextLeftNumber($node->parent, $node, $number);
        } else {
            //called from right node
            $leftNode = $node->left;
            if ($leftNode instanceof Node) {
                $this->addToTheRight($node->left, $number);
            } else {
                $node->left += $number;
            }
        }
    }

    private function addToNextRightNumber(Node $node, Node $callingNode, int $number)
    {
        if ($node->right === $callingNode) {
            if ($node->parent === null) {
                return;
            }

            $this->addToNextRightNumber($node->parent, $node, $number);
        } else {

            $rightNode = $node->right;
            if ($rightNode instanceof Node) {
                $this->addToTheLeft($node->right, $number);
            } else {
                $node->right += $number;
            }
        }
    }

    public function addToTheRight(Node $node, int $number)
    {
        if ($node->right instanceof Node) {
            $this->addToTheRight($node->right, $number);
        } else {
            $node->right += $number;
        }
    }

    public function addToTheLeft(Node $node, int $number)
    {
        if ($node->left instanceof Node) {
            $this->addToTheLeft($node->left, $number);
        } else {
            $node->left += $number;
        }
    }

    public function stringToNodes(array &$chars, Node $node)
    {
        $char = array_shift($chars);
        if ($char === '[') {
            $newNode = new Node();
            $node->left = $newNode;
            $newNode->parent = $node;
            $this->stringToNodes($chars, $newNode);
        } else {
            $node->left = (int)$char;
        }
        $char = array_shift($chars);
        if ($char !== ',') {
            throw new \Exception('I should have found here a split character');
        }

        $nextChar = array_shift($chars);

        if ($nextChar === '[') {
            $newNode = new Node();
            $node->right = $newNode;
            $newNode->parent = $node;
            $this->stringToNodes($chars, $newNode);
        } else {
            $node->right = (int)$nextChar;
        }
        $char = array_shift($chars);

        if ($char != ']') {
            throw new \Exception('I should have found here a closing character');
        }
    }

    public function secondPart(string $input)
    {
        $lines = [];

        foreach (explode("\n", trim($input)) as $line) {
            $chars = str_split(trim($line));
            $firstCharacter = array_shift($chars);
            if ($firstCharacter != '[') {
                throw new \Exception('I should have found here an opening character');
            }
            $node = new Node();
            $this->stringToNodes($chars, $node);

            $lines[] = $node;
        }

        $keys = [];

        $count = count($lines);
        for ($i = 0; $i < ($count-1); $i++) {
            for ($j = $i + 1; $j < $count; $j++) {
                $keys[$i][] = $j;
                $keys[$j][] = $i;
            }
        }


        $magnitude = 0;
        foreach ($keys as $groupKey => $moreKeys) {
            foreach ($moreKeys as $key) {
                $first = unserialize(serialize($lines[$groupKey]));
                $second = unserialize(serialize($lines[$key]));

                $node = new Node();
                $node->left = $first;
                $node->right = $second;
                $second->parent = $first->parent = $node;
                $this->performActions($node);
                $newMagnitude = $this->calculateMagnitude($node);
                if ($newMagnitude > $magnitude) {
                    $magnitude = $newMagnitude;
                }
            }
        }

        return $magnitude;
    }
}

class Node
{
    public $left;
    public $right;
    /** @var null|Node */
    public $parent;
}
