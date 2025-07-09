<?php

declare(strict_types=1);

namespace App\Service\API;

use GuzzleHttp\ClientInterface;

final readonly class RickAndMortyService
{
    private const BASE_URI = 'https://rickandmortyapi.com';

    public function __construct(
        private ClientInterface $guzzle,
    ) {
    }

    /**
     * @return list<array{id: int, name: string, date: string}>
     */
    public function getAllEpisodes(): array
    {
        $response = $this->guzzle->request('GET', self::BASE_URI . '/api/episode');

        if (200 !== $response->getStatusCode()) {
            return [];
        }

        $bodyDecoded = json_decode((string) $response->getBody(), true);

        if (!array_key_exists('results', $bodyDecoded) || empty($bodyDecoded['results'])) {
            return [];
        }

        $result = [];

        foreach ($bodyDecoded['results'] as $episode) {
            $result[] = [
                'id' => $episode['id'],
                'name' => $episode['name'],
                'date' => $episode['air_date'],
            ];
        }

        return $result;
    }
}
