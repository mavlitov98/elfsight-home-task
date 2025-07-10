<?php

declare(strict_types=1);

namespace App\Application\Episode\DTO;

final readonly class EpisodeResponse
{
    public function __construct(
        public int $id,
        public string $name,
        public string $releaseDate,
    ) {
    }
}
