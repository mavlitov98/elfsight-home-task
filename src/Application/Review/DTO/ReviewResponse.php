<?php

declare(strict_types=1);

namespace App\Application\Review\DTO;

final readonly class ReviewResponse
{
    public function __construct(
        public string $message,
    ) {
    }
}
