<?php

declare(strict_types=1);

namespace App\Domain\Episode\Repository;

use App\Domain\Episode\Entity\Episode;

interface EpisodeRepositoryInterface
{
    public function add(Episode $episode): void;

    public function flush(): void;

    public function deleteAll(): void;

    public function getById(int $id): ?Episode;

    public function getAll(): array;
}
