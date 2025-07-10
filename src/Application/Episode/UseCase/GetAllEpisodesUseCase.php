<?php

declare(strict_types=1);

namespace App\Application\Episode\UseCase;

use App\Application\Episode\DTO\EpisodeResponse;
use App\Domain\Episode\Entity\Episode;
use App\Domain\Episode\Repository\EpisodeRepositoryInterface;

class GetAllEpisodesUseCase
{
    public function __construct(
        private readonly EpisodeRepositoryInterface $episodeRepository,
    ) {
    }

    /**
     * @return list<EpisodeResponse>
     */
    public function execute(): array
    {
        return array_map(
            static fn (Episode $episode) => new EpisodeResponse($episode->id, $episode->name, $episode->date->format('Y-m-d')),
            $this->episodeRepository->getAll(),
        );
    }
}
