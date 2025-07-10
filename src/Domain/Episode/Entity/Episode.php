<?php

declare(strict_types=1);

namespace App\Domain\Episode\Entity;

use App\Infrastructure\Persistence\EpisodeRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Entity;

/**
 * @psalm-suppress ClassMustBeFinal
 */
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
