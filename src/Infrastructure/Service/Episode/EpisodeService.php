<?php

declare(strict_types=1);

namespace App\Infrastructure\Service\Episode;

use App\Domain\Episode\Service\EpisodeServiceInterface;
use App\Infrastructure\Service\RickAndMortyService;

final readonly class EpisodeService implements EpisodeServiceInterface
{
    public function __construct(
        private RickAndMortyService $rickAndMortyService,
    ) {
    }

    /**
     * @return list<array{id: int, name: string, date: string}>
     */
    public function fetchAll(): array
    {
        return $this->rickAndMortyService->getAllEpisodes();
    }
}
