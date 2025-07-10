<?php

declare(strict_types=1);

namespace App\Application\Episode\UseCase;

use App\Domain\Episode\Entity\Episode;
use App\Domain\Episode\Repository\EpisodeRepositoryInterface;
use App\Domain\Episode\Service\EpisodeServiceInterface;
use DateTimeImmutable;

final readonly class FetchAllEpisodesUseCase
{
    public function __construct(
        private EpisodeServiceInterface $episodeService,
        private EpisodeRepositoryInterface $episodeRepository,
    ) {
    }

    public function execute(): int
    {
        $episodes = $this->episodeService->fetchAll();

        if (empty($episodes)) {
            return 0;
        }

        $this->episodeRepository->deleteAll();

        foreach ($episodes as $episode) {
            $entity = new Episode(
                id: $episode['id'],
                name: $episode['name'],
                date: new DateTimeImmutable($episode['date']),
            );

            $this->episodeRepository->add($entity);
        }

        $this->episodeRepository->flush();

        return count($episodes);
    }
}
