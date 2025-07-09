<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\EpisodeRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping as ORM;

#[Entity(repositoryClass: EpisodeRepository::class)]
class Episode
{
    public function __construct(
        #[ORM\Id]
        #[ORM\Column(type: 'integer')]
        public int $id,

        #[ORM\Column(type: 'string', length: 255)]
        public string $name,

        #[ORM\Column(type: 'datetime_immutable')]
        public DateTimeImmutable $date,
    ) {
    }
}
