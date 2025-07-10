<?php

declare(strict_types=1);

namespace App\Domain\Episode\Service;

interface EpisodeServiceInterface
{
    /**
     * @return list<array{id: int, name: string, date: string}>
     */
    public function fetchAll(): array;
}
