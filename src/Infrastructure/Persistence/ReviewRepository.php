<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence;

use App\Domain\Episode\Entity\Episode;
use App\Domain\Review\Entity\Review;
use App\Domain\Review\Repository\ReviewRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Review|null find($id, $lockMode = null, $lockVersion = null)
 * @method Review|null findOneBy(array $criteria, array $orderBy = null)
 * @method Review[]    findAll()
 * @method Review[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class ReviewRepository extends ServiceEntityRepository implements ReviewRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Review::class);
    }

    public function save(Review $review): void
    {
        $this->getEntityManager()->persist($review);
        $this->getEntityManager()->flush();
    }

    public function findByEpisode(Episode $episode): array
    {
        return $this->findBy(['episode' => $episode]);
    }

    public function findLastN(Episode $episode, int $limit): array
    {
        return $this->findBy(
            criteria: ['episode' => $episode],
            orderBy: ['createdAt' => 'DESC'],
            limit: $limit,
        );
    }
}
