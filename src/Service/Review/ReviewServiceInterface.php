<?php

declare(strict_types=1);

namespace App\Service\Review;

interface ReviewServiceInterface
{
    public function submit(ReviewRequest $request): ReviewResponse;
}
