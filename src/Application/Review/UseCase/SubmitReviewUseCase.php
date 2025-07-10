<?php

declare(strict_types=1);

namespace App\Application\Review\UseCase;

use App\Application\Review\DTO\ReviewRequest;
use App\Application\Review\DTO\ReviewResponse;
use App\Domain\Review\Service\ReviewServiceInterface;

final readonly class SubmitReviewUseCase
{
    public function __construct(
        private ReviewServiceInterface $reviewService,
    ) {
    }

    public function execute(ReviewRequest $request): ReviewResponse
    {
        return $this->reviewService->submit($request);
    }
}
