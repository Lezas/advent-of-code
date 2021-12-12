<?php

namespace AdventOfCode\Year2021\Day12;

use AdventOfCode\PuzzleInterface;

class Puzzle implements PuzzleInterface
{
    public function firstPart(string $input)
    {
        $lines = explode("\n", trim($input));
        $nodes = [];

        $startNode = null;
        $count = 0;

        foreach ($lines as $line) {
            $count++;
            [$fromNodeString, $toNodeString] = explode('-', trim($line));

            if (!isset($nodes[$toNodeString])) {
                $toNode = new Node();
                $toNode->char = $toNodeString;
                $toNode->bigCave = ctype_upper($toNodeString);
                $nodes[$toNodeString] = $toNode;
            } else {
                $toNode = $nodes[$toNodeString];
            }

            if (!isset($nodes[$fromNodeString])) {
                $fromNode = new Node();
                $fromNode->char = $fromNodeString;
                $fromNode->bigCave = ctype_upper($fromNodeString);
                $nodes[$fromNodeString] = $fromNode;
            } else {
                $fromNode = $nodes[$fromNodeString];
            }

            if (null === $startNode) {
                if ($fromNodeString === 'start') {
                    $startNode = $fromNode;
                } elseif ($toNodeString === 'start') {
                    $startNode = $toNode;
                }
            }

            $fromNode->childeNodes[] = $toNode;
            $toNode->childeNodes[] = $fromNode;

        }

        $currentPath = [
            'nodes'   => [
                $startNode,
            ],
            'visited' => [
                $startNode->char => 1,
            ],
        ];

        $foundPaths = [];
        foreach ($startNode->childeNodes as $childeNode) {
            $this->findPaths($childeNode, $currentPath, $foundPaths);
        }

//        foreach ($foundPaths as $foundPath) {
//            echo implode(',',array_map(function (Node $node) {
//                return $node->char;
//            }, $foundPath['nodes'])) . PHP_EOL;
//        }

        return count($foundPaths);
    }

    public function findPaths(Node $node, array $currentPath, array &$foundPaths)
    {
        if ($node->char === 'end') {
            $currentPath['nodes'][] = $node;
            $foundPaths[] = $currentPath;

            return;
        }

        if (ctype_lower($node->char)) {
            if (isset($currentPath['visited'][$node->char])) {
                return;
            }

            $currentPath['nodes'][] = $node;
            if (!isset($currentPath['visited'][$node->char])) {
                $currentPath['visited'][$node->char] = 1;
            } else {
                $currentPath['visited'][$node->char]++;
            }
            foreach ($node->childeNodes as $childeNode) {
                $this->findPaths($childeNode, $currentPath, $foundPaths);
            }
            foreach ($node->parentNodes as $childeNode) {
                $this->findPaths($childeNode, $currentPath, $foundPaths);
            }
        } else {
            $currentPath['nodes'][] = $node;
            if (!isset($currentPath['visited'][$node->char])) {
                $currentPath['visited'][$node->char] = 1;
            } else {
                $currentPath['visited'][$node->char]++;
            }
            foreach ($node->childeNodes as $childeNode) {
                $this->findPaths($childeNode, $currentPath, $foundPaths);
            }
            foreach ($node->parentNodes as $childeNode) {
                $this->findPaths($childeNode, $currentPath, $foundPaths);
            }
        }
    }

    public function secondPart(string $input)
    {
        $lines = explode("\n", trim($input));
        $nodes = [];

        $startNode = null;
        $count = 0;

        foreach ($lines as $line) {
            $count++;
            [$fromNodeString, $toNodeString] = explode('-', trim($line));

            if (!isset($nodes[$toNodeString])) {
                $toNode = new Node();
                $toNode->char = $toNodeString;
                $toNode->bigCave = ctype_upper($toNodeString);
                $nodes[$toNodeString] = $toNode;
            } else {
                $toNode = $nodes[$toNodeString];
            }

            if (!isset($nodes[$fromNodeString])) {
                $fromNode = new Node();
                $fromNode->char = $fromNodeString;
                $fromNode->bigCave = ctype_upper($fromNodeString);
                $nodes[$fromNodeString] = $fromNode;
            } else {
                $fromNode = $nodes[$fromNodeString];
            }

            if (null === $startNode) {
                if ($fromNodeString === 'start') {
                    $startNode = $fromNode;
                } elseif ($toNodeString === 'start') {
                    $startNode = $toNode;
                }
            }

            $fromNode->childeNodes[] = $toNode;
            $toNode->childeNodes[] = $fromNode;

        }

        $currentPath = [
            'nodes'              => [
                $startNode,
            ],
            'visited'            => [
                $startNode->char => 1,
            ],
            'lastDoubleNodeChar' => null,
        ];

        $foundPaths = 0;
        foreach ($startNode->childeNodes as $childeNode) {
            $this->findPathsPart2($childeNode, $currentPath, $foundPaths);
        }

//        foreach ($foundPaths as $foundPath) {
//            echo implode(',',array_map(function (Node $node) {
//                    return $node->char;
//                }, $foundPath['nodes'])) . PHP_EOL;
//        }

        return $foundPaths;
    }

    public function findPathsPart2(Node $node, array $currentPath, int &$foundPaths)
    {
        if ($node->char === 'end') {
            $currentPath['nodes'][] = $node;
            $foundPaths++;

            return;
        }

        if (ctype_lower($node->char)) {
            if (isset($currentPath['visited'][$node->char])) {
                if (in_array($node->char, ['start', 'end'])) {
                    return;
                }
                if ($currentPath['lastDoubleNodeChar'] !== null) {
                    return;
                }
            }

            $currentPath['nodes'][] = $node;
            if (!isset($currentPath['visited'][$node->char])) {
                $currentPath['visited'][$node->char] = 1;
            } else {
                $currentPath['visited'][$node->char]++;
                $currentPath['lastDoubleNodeChar'] = $node->char;
            }
            foreach ($node->childeNodes as $childeNode) {
                $this->findPathsPart2($childeNode, $currentPath, $foundPaths);
            }
        } else {
            $currentPath['nodes'][] = $node;
            if (!isset($currentPath['visited'][$node->char])) {
                $currentPath['visited'][$node->char] = 1;
            } else {
                $currentPath['visited'][$node->char]++;
            }
            foreach ($node->childeNodes as $childeNode) {
                $this->findPathsPart2($childeNode, $currentPath, $foundPaths);
            }
        }
    }
}

class Node
{
    public $char;
    public $bigCave = false;
    public $parentNodes = [];

    public $childeNodes = [];
}
