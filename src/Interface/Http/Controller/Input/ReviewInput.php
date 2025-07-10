<?php

declare(strict_types=1);

namespace App\Interface\Http\Controller\Input;

final class ReviewInput
{
    public function __construct(
        public int $episodeId,
        public string $content,
    ) {
    }
}
