<?php

declare(strict_types=1);

namespace App\Service\Review;

final readonly class ReviewResponse
{
    public function __construct(
        public string $message,
    ) {
    }
}
