<?php

declare(strict_types=1);

namespace App\Service\API;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\RequestOptions;
use RuntimeException;
use Throwable;

final readonly class RickAndMortyService
{
    private const URL = 'https://rickandmortyapi.com/api/episode';
    private const DEFAULT_PAGE_COUNT = 1;
    private const HTTP_OK = 200;

    public function __construct(
        private ClientInterface $guzzle,
    ) {
    }

    /**
     * @return array<array{id: int, name: string, date: string}>
     */
    public function getAllEpisodes(): array
    {
        try {
            $totalPages = $this->getTotalPagesCount();
            $episodes = [];

            for ($page = 1; $page <= $totalPages; $page++) {
                $episodes = [...$episodes, ...$this->getEpisodesByPage($page)];
            }

            return $episodes;
        } catch (Throwable $e) {
            throw new RuntimeException('Failed to fetch episodes: ' . $e->getMessage());
        }
    }

    /**
     * @return array<array{id: int, name: string, date: string}>
     */
    private function getEpisodesByPage(int $page): array
    {
        $response = $this->guzzle->request('GET', self::URL, [
            RequestOptions::QUERY => ['page' => $page],
        ]);

        if (self::HTTP_OK !== $response->getStatusCode()) {
            return [];
        }

        $bodyDecoded = json_decode(
            json: (string)$response->getBody(),
            associative: true,
            flags: JSON_THROW_ON_ERROR,
        );

        if (empty($bodyDecoded['results'] ?? [])) {
            return [];
        }

        return array_map(
            static fn(array $episode): array => [
                'id' => $episode['id'],
                'name' => $episode['name'],
                'date' => $episode['air_date'],
            ],
            $bodyDecoded['results']
        );
    }

    private function getTotalPagesCount(): int
    {
        $response = $this->guzzle->request('GET', self::URL);

        if (self::HTTP_OK !== $response->getStatusCode()) {
            return self::DEFAULT_PAGE_COUNT;
        }

        $bodyDecoded = json_decode(
            json: (string)$response->getBody(),
            associative: true,
            flags: JSON_THROW_ON_ERROR,
        );

        return $bodyDecoded['info']['pages'] ?? self::DEFAULT_PAGE_COUNT;
    }
}
