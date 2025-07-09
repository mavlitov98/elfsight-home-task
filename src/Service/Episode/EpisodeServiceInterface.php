<?php

declare(strict_types=1);

namespace App\Service\Episode;

interface EpisodeServiceInterface
{
    /**
     * @return list<EpisodeResponse>
     */
    public function getAll(): array;
}
