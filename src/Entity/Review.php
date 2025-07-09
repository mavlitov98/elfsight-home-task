<?php

declare(strict_types=1);

namespace App\Entity;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ReviewRepository;

#[ORM\Entity(repositoryClass: ReviewRepository::class)]
class Review
{
    public function __construct(
        #[ORM\Id]
        #[ORM\GeneratedValue]
        #[ORM\Column(type: 'integer')]
        public int $id,

        #[ORM\ManyToOne(targetEntity: Episode::class)]
        #[ORM\JoinColumn(nullable: false)]
        public Episode $episode,

        #[ORM\Column(type: 'string', length: 1000)]
        public string $content,

        #[ORM\Column(type: 'float')]
        public float $sentimentScore,

        #[ORM\Column(type: 'datetime_immutable')]
        public DateTimeImmutable $createdAt,
    ) {
    }
}
