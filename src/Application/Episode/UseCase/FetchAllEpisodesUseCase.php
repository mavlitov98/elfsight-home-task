<?php

declare(strict_types=1);

namespace App\Application\Episode\UseCase;

use App\Application\Episode\DTO\EpisodeResponse;
use App\Domain\Episode\Service\EpisodeServiceInterface;

class FetchAllEpisodesUseCase
{
    public function __construct(
        private readonly EpisodeServiceInterface $episodeService,
    ) {
    }

    /**
     * @return list<EpisodeResponse>
     */
    public function execute(): array
    {
        return array_map(
            static fn (array $episode) => new EpisodeResponse($episode['id'], $episode['name'], $episode['date']),
            $this->episodeService->fetchAll(),
        );
    }
}
