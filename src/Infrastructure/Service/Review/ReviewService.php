<?php

declare(strict_types=1);

namespace App\Infrastructure\Service\Review;

use App\Application\Review\DTO\ReviewRequest;
use App\Application\Review\DTO\ReviewResponse;
use App\Domain\Review\Entity\Review;
use App\Domain\Review\Service\ReviewServiceInterface;
use App\Infrastructure\Persistence\EpisodeRepository;
use App\Infrastructure\Persistence\ReviewRepository;
use App\Infrastructure\Service\Sentiment\SentimentService;
use DateTimeImmutable;
use Override;

final readonly class ReviewService implements ReviewServiceInterface
{
    public function __construct(
        private EpisodeRepository $episodeRepository,
        private ReviewRepository $reviewRepository,
        private SentimentService $sentimentService,
    ) {
    }

    #[Override]
    public function submit(ReviewRequest $request): ReviewResponse
    {
        $episode = $this->episodeRepository->getById($request->episodeId);

        if (null === $episode) {
            return new ReviewResponse('Episode not found.');
        }

        $review = new Review(
            episode: $episode,
            content: $request->content,
            sentimentScore: $this->sentimentService->getScore($request->content),
            createdAt: new DateTimeImmutable(),
        );

        $this->reviewRepository->save($review);

        return new ReviewResponse('Review submitted.');
    }
}
