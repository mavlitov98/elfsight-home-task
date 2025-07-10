<?php

declare(strict_types=1);

namespace App\Tests\Unit\Application\Episode\UseCase;

use App\Application\Episode\DTO\EpisodeSummaryLastReview;
use App\Application\Episode\DTO\EpisodeSummaryResponse;
use App\Application\Episode\UseCase\GetEpisodeSummaryUseCase;
use App\Domain\Episode\Entity\Episode;
use App\Domain\Episode\Repository\EpisodeRepositoryInterface;
use App\Domain\Review\Entity\Review;
use App\Domain\Review\Repository\ReviewRepositoryInterface;
use Codeception\Test\Unit;
use DateTimeImmutable;

final class GetEpisodeSummaryUseCaseTest extends Unit
{
    public function testReturnsNullWhenEpisodeNotFound(): void
    {
        $episodeRepo = $this->createMock(EpisodeRepositoryInterface::class);
        $episodeRepo->method('getById')->willReturn(null);

        $reviewRepo = $this->createMock(ReviewRepositoryInterface::class);

        $useCase = new GetEpisodeSummaryUseCase($episodeRepo, $reviewRepo);

        $result = $useCase->execute(1);

        $this->assertNull($result);
    }

    public function testReturnsSummaryWithAverageAndLastReviews(): void
    {
        $episode = new Episode(1, 'Test Episode', new DateTimeImmutable('2024-01-01'));

        $reviews = [
            $this->createReview('Good', 0.8, '2024-02-01 10:00:00'),
            $this->createReview('Bad', -0.2, '2024-02-02 11:00:00'),
            $this->createReview('Neutral', 0.4, '2024-02-03 12:00:00'),
        ];

        $episodeRepo = $this->createMock(EpisodeRepositoryInterface::class);
        $episodeRepo->method('getById')->willReturn($episode);

        $reviewRepo = $this->createMock(ReviewRepositoryInterface::class);
        $reviewRepo->method('findByEpisode')->willReturn($reviews);
        $reviewRepo->method('findLastN')->willReturn($reviews);

        $useCase = new GetEpisodeSummaryUseCase($episodeRepo, $reviewRepo);
        $response = $useCase->execute(1);

        $this->assertInstanceOf(EpisodeSummaryResponse::class, $response);
        $this->assertSame('Test Episode', $response->name);
        $this->assertSame('2024-01-01', $response->releaseDate);
        $this->assertEquals(0.333, $response->averageSentimentScore);

        $this->assertCount(3, $response->lastReviews);
        $this->assertContainsOnlyInstancesOf(EpisodeSummaryLastReview::class, $response->lastReviews);
        $this->assertSame('Good', $response->lastReviews[0]->content);
        $this->assertSame('2024-02-01 10:00:00', $response->lastReviews[0]->createdAt);
    }

    private function createReview(string $content, float $score, string $createdAt): Review
    {
        $review = $this->createMock(Review::class);
        $review->content = $content;
        $review->sentimentScore = $score;
        $review->createdAt = new DateTimeImmutable($createdAt);

        return $review;
    }
}
