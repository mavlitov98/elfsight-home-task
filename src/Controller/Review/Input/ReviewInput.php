<?php

declare(strict_types=1);

namespace App\Controller\Review\Input;

class ReviewInput
{
    public function __construct(
        public int $episodeId,
        public string $content,
    ) {
    }
}
