<?php

declare(strict_types=1);

namespace App\Service\Review;

final readonly class ReviewRequest
{
    public function __construct(
        public int $episodeId,
        public string $content,
    ) {
    }
}
