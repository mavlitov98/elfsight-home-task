<?php

declare(strict_types=1);

namespace App\Domain\Review\Service;

use App\Application\Review\DTO\ReviewRequest;
use App\Application\Review\DTO\ReviewResponse;

interface ReviewServiceInterface
{
    public function submit(ReviewRequest $request): ReviewResponse;
}
