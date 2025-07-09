<?php

declare(strict_types=1);

namespace App\Service\Review;

use App\Entity\Review;
use App\Repository\EpisodeRepository;
use App\Repository\ReviewRepository;
use App\Service\API\SentimentService;
use DateTimeImmutable;

final readonly class ReviewService implements ReviewServiceInterface
{
    public function __construct(
        private EpisodeRepository $episodeRepository,
        private ReviewRepository $reviewRepository,
        private SentimentService $sentimentService,
    ) {
    }

    public function submit(ReviewRequest $request): ReviewResponse
    {
        $episode = $this->episodeRepository->find($request->episodeId);

        if (null === $episode) {
            return new ReviewResponse('Episode not found.');
        }

        $review = new Review(
            episode: $episode,
            content: $request->content,
            sentimentScore: $this->sentimentService->getScore($request->content),
            createdAt: new DateTimeImmutable()
        );

        $this->reviewRepository->save($review);

        return new ReviewResponse('Review submitted.');
    }
}
