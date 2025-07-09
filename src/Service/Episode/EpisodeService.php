<?php

declare(strict_types=1);

namespace App\Service\Episode;

use App\Service\API\RickAndMortyService;

final readonly class EpisodeService implements EpisodeServiceInterface
{
    public function __construct(
        private RickAndMortyService $rickAndMortyService,
    ) {
    }

    /**
     * @return list<EpisodeResponse>
     */
    public function getAll(): array
    {
        return array_map(
            fn (array $episode) => new EpisodeResponse($episode['id'], $episode['name'], $episode['date']),
            $this->rickAndMortyService->getAllEpisodes(),
        );
    }
}
