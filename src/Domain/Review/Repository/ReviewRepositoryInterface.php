<?php

declare(strict_types=1);

namespace App\Domain\Review\Repository;

use App\Domain\Episode\Entity\Episode;
use App\Domain\Review\Entity\Review;

interface ReviewRepositoryInterface
{
    public function save(Review $review): void;

    public function findByEpisode(Episode $episode): array;

    public function findLastN(Episode $episode, int $limit): array;
}
