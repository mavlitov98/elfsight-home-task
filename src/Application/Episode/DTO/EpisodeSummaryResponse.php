<?php

declare(strict_types=1);

namespace App\Application\Episode\DTO;

final readonly class EpisodeSummaryResponse
{
    /**
     * @param list<EpisodeSummaryLastReview> $lastReviews
     */
    public function __construct(
        public string $name,
        public string $releaseDate,
        public ?float $averageSentimentScore,
        public array $lastReviews,
    ) {
    }
}
