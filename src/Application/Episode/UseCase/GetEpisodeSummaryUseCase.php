<?php

declare(strict_types=1);

namespace App\Application\Episode\UseCase;

use App\Application\Episode\DTO\EpisodeSummaryLastReview;
use App\Application\Episode\DTO\EpisodeSummaryResponse;
use App\Domain\Episode\Repository\EpisodeRepositoryInterface;
use App\Domain\Review\Entity\Review;
use App\Domain\Review\Repository\ReviewRepositoryInterface;

final readonly class GetEpisodeSummaryUseCase
{
    public function __construct(
        private EpisodeRepositoryInterface $episodeRepository,
        private ReviewRepositoryInterface $reviewRepository,
    ) {
    }

    public function execute(int $episodeId): ?EpisodeSummaryResponse
    {
        $episode = $this->episodeRepository->getById($episodeId);

        if (null === $episode) {
            return null;
        }

        $reviews = $this->reviewRepository->findByEpisode($episode);

        $avg = count($reviews) > 0
            ? round(array_sum(array_map(fn (Review $r) => $r->sentimentScore, $reviews)) / ((float) count($reviews)), 3)
            : null;

        $lastReviews = $this->reviewRepository->findLastN($episode, 3);

        return new EpisodeSummaryResponse(
            name: $episode->name,
            releaseDate: $episode->date->format('Y-m-d'),
            averageSentimentScore: $avg,
            lastReviews: array_map(
                static fn (Review $review) => new EpisodeSummaryLastReview(
                    content: $review->content,
                    sentimentScore: $review->sentimentScore,
                    createdAt: $review->createdAt->format('Y-m-d H:i:s'),
                ),
                $lastReviews,
            ),
        );
    }
}
