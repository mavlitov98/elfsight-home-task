<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence;

use App\Domain\Episode\Entity\Episode;
use App\Domain\Episode\Repository\EpisodeRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Episode|null find($id, $lockMode = null, $lockVersion = null)
 * @method Episode|null findOneBy(array $criteria, array $orderBy = null)
 * @method Episode[]    findAll()
 * @method Episode[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EpisodeRepository extends ServiceEntityRepository implements EpisodeRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Episode::class);
    }

    public function add(Episode $episode): void
    {
        $this->getEntityManager()->persist($episode);
    }

    public function flush(): void
    {
        $this->getEntityManager()->flush();
    }

    public function deleteAll(): void
    {
        $this->createQueryBuilder('e')
            ->delete()
            ->getQuery()
            ->execute();
    }

    public function getById(int $id): ?Episode
    {
        return $this->find($id);
    }

    public function getAll(): array
    {
        return $this->findAll();
    }
}
