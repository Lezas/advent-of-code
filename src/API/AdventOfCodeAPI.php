<?php

namespace AdventOfCode\API;

use Symfony\Component\HttpClient\HttpClient;

class AdventOfCodeAPI
{
    public static function getPuzzleInput(int $year, int $day): string
    {
        $url = sprintf('https://adventofcode.com/%d/day/%d/input', $year, $day);

        $sessionId = $_ENV['AOC_SESSIONID'];

        if (empty($sessionId)) {
            throw new \Exception('Empty session ID');
        }

        $client = HttpClient::create();
        $response = $client->request('GET', $url, [
                'headers' => ['Cookie' => 'session=' . $sessionId],
            ]
        );

        return $response->getContent();
    }

    public static function sendPuzzleAnswer(int $year, int $day, string $part, string $answer): void
    {
        if ($_ENV['API_POST_REQUEST_OFF'] == 1) {
            throw new \Exception('Post requests turned off');
        }
        switch ($part) {
            case 'first':
                $level = 1;
                break;
            case 'second':
                $level = 2;
                break;
            default:
                throw new \Exception(sprintf('Undefined part %s', $part));
        }

        $url = sprintf('https://adventofcode.com/%d/day/%d/answer', $year, $day);
        $sessionId = $_ENV['AOC_SESSIONID'];

        $client = HttpClient::create();
        $response = $client->request(
            'POST',
            $url,
            [
                'headers' => ['Cookie' => 'session=' . $sessionId],
                'body' => [
                    'level' => $level,
                    'answer' => $answer
                ],
            ]
        );

        if ($response->getStatusCode() !== 200) {
            var_dump($response);
            throw new \Exception('Got wrong HTTP status code after sending the answer');
        }
    }
}