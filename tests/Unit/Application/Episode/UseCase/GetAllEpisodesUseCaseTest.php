<?php

declare(strict_types=1);

namespace App\Tests\Unit\Application\Episode\UseCase;

use App\Application\Episode\DTO\EpisodeResponse;
use App\Application\Episode\UseCase\GetAllEpisodesUseCase;
use App\Domain\Episode\Entity\Episode;
use App\Domain\Episode\Repository\EpisodeRepositoryInterface;
use Codeception\Test\Unit;
use DateTimeImmutable;

final class GetAllEpisodesUseCaseTest extends Unit
{
    public function testExecuteReturnsEpisodeResponses(): void
    {
        $episodes = [
            new Episode(id: 1, name: 'Ep 1', date: new DateTimeImmutable('2025-01-01')),
            new Episode(id: 2, name: 'Ep 2', date: new DateTimeImmutable('2025-01-02')),
        ];

        $mockRepository = $this->createMock(EpisodeRepositoryInterface::class);
        $mockRepository->method('getAll')->willReturn($episodes);

        $useCase = new GetAllEpisodesUseCase($mockRepository);

        $result = $useCase->execute();

        $this->assertCount(2, $result);
        $this->assertContainsOnlyInstancesOf(EpisodeResponse::class, $result);

        $this->assertEquals(new EpisodeResponse(1, 'Ep 1', '2025-01-01'), $result[0]);
        $this->assertEquals(new EpisodeResponse(2, 'Ep 2', '2025-01-02'), $result[1]);
    }
}
