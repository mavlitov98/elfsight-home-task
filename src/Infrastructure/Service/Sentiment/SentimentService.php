<?php

declare(strict_types=1);

namespace App\Infrastructure\Service\Sentiment;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\RequestOptions;

final readonly class SentimentService
{
    private const URL = 'http://python:5000/analyze';

    public function __construct(
        private ClientInterface $guzzle,
    ) {
    }

    public function getScore(string $text): float
    {
        $response = $this->guzzle->request('POST', self::URL, [
            RequestOptions::JSON => ['text' => $text],
        ]);

        /** @var array{score: float} $decoded */
        $decoded = json_decode((string) $response->getBody(), true);

        return $decoded['score'];
    }
}
