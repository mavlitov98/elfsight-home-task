<?php

declare(strict_types=1);

namespace App\Service\Episode;

final readonly class EpisodeResponse
{
    public function __construct(
        public int $id,
        public string $name,
        public string $date,
    ) {
    }
}
