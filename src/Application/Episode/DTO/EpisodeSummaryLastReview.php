<?php

declare(strict_types=1);

namespace App\Application\Episode\DTO;

final readonly class EpisodeSummaryLastReview
{
    public function __construct(
        public string $content,
        public float $sentimentScore,
        public string $createdAt,
    ) {
    }
}
