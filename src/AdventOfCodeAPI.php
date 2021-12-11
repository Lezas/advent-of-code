<?php

namespace AdventOfCode;

use Symfony\Component\HttpClient\HttpClient;

class AdventOfCodeAPI
{
    public static function getPuzzleInput(int $year, int $day): string
    {
        $link = sprintf('https://adventofcode.com/%d/day/%d/input', $year, $day);

        $sessionId = $_ENV['AOC_SESSIONID'];

        if (empty($sessionId)) {
            throw new \Exception('Empty session ID');
        }

        $client = HttpClient::create();
        $response = $client->request('GET', $link, [
                'headers' => ['Cookie' => 'session=' . $sessionId],
            ]
        );

        return $response->getContent();
    }
}