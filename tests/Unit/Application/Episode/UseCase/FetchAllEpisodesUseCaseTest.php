<?php

declare(strict_types=1);

namespace App\Tests\Unit\Application\Episode\UseCase;

use App\Application\Episode\UseCase\FetchAllEpisodesUseCase;
use App\Domain\Episode\Repository\EpisodeRepositoryInterface;
use App\Domain\Episode\Service\EpisodeServiceInterface;
use Codeception\Test\Unit;

final class FetchAllEpisodesUseCaseTest extends Unit
{
    public function testExecuteReturnsZeroWhenNoEpisodes(): void
    {
        $episodeService = $this->createMock(EpisodeServiceInterface::class);
        $episodeService->method('fetchAll')->willReturn([]);

        $episodeRepository = $this->createMock(EpisodeRepositoryInterface::class);
        $episodeRepository->expects($this->never())->method('add');
        $episodeRepository->expects($this->never())->method('flush');

        $useCase = new FetchAllEpisodesUseCase($episodeService, $episodeRepository);
        $result = $useCase->execute();

        $this->assertSame(0, $result);
    }

    public function testExecuteImportsEpisodes(): void
    {
        $episodeData = [
            ['id' => 1, 'name' => 'Episode 1', 'date' => '2025-01-01'],
            ['id' => 2, 'name' => 'Episode 2', 'date' => '2025-01-02'],
        ];

        $episodeService = $this->createMock(EpisodeServiceInterface::class);
        $episodeService->method('fetchAll')->willReturn($episodeData);

        $episodeRepository = $this->createMock(EpisodeRepositoryInterface::class);
        $episodeRepository->expects($this->once())->method('deleteAll');
        $episodeRepository->expects($this->exactly(2))->method('add');
        $episodeRepository->expects($this->once())->method('flush');

        $useCase = new FetchAllEpisodesUseCase($episodeService, $episodeRepository);
        $result = $useCase->execute();

        $this->assertSame(2, $result);
    }
}
