<?php

declare(strict_types=1);

namespace App\Domain\Episode\Entity;

use App\Domain\Review\Entity\Review;
use App\Infrastructure\Persistence\EpisodeRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\Serializer\Attribute\Ignore;

/**
 * @psalm-suppress ClassMustBeFinal
 */
#[Entity(repositoryClass: EpisodeRepository::class)]
class Episode
{
    #[ORM\OneToMany(targetEntity: Review::class, mappedBy: 'episode')]
    #[Ignore]
    private Collection $reviews;

    public function __construct(
        #[ORM\Id]
        #[ORM\Column(type: 'integer')]
        public int $id,

        #[ORM\Column(type: 'string', length: 255)]
        public string $name,

        #[ORM\Column(type: 'datetime_immutable')]
        public DateTimeImmutable $date,
    ) {
        $this->reviews = new ArrayCollection();
    }

    public function getReviews(): array
    {
        return $this->reviews->toArray();
    }
}
