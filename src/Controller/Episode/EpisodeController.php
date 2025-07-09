<?php

declare(strict_types=1);

namespace App\Controller\Episode;

use App\Entity\Review;
use App\Repository\EpisodeRepository;
use App\Repository\ReviewRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class EpisodeController extends AbstractController
{
    public function __construct(
        private readonly EpisodeRepository $episodeRepository,
        private readonly ReviewRepository $reviewRepository,
    ) {
    }

    #[Route(path: '/episode/all', methods: ['GET'])]
    public function getAllEpisodes(): JsonResponse
    {
        $episodes = $this->episodeRepository->findAll();

        return $this->json($episodes);
    }

    #[Route('/episode/{id}/summary', methods: ['GET'])]
    public function getEpisodeSummary(int $id): JsonResponse
    {
        $episode = $this->episodeRepository->find($id);

        if (null === $episode) {
            return $this->json(['error' => 'Episode not found.'], 404);
        }

        $reviews = $this->reviewRepository->findBy(['episode' => $episode]);
        $sumScores = array_sum(array_map(fn(Review $review) => $review->sentimentScore, $reviews));

        $averageSentiment = count($reviews) > 0
            ? round(num: $sumScores / count($reviews), precision: 3)
            : null;

        $lastThreeReviews = $this->reviewRepository->findBy(
            ['episode' => $episode],
            ['createdAt' => 'DESC'],
            3
        );

        return $this->json([
            'name' => $episode->name,
            'releaseDate' => $episode->date->format('Y-m-d'),
            'averageSentimentScore' => $averageSentiment,
            'lastReviews' => array_map(
                static fn (Review $review) => [
                    'content' => $review->content,
                    'sentimentScore' => $review->sentimentScore,
                    'createdAt' => $review->createdAt->format('Y-m-d H:i:s'),
                ],
                $lastThreeReviews
            ),
        ]);
    }
}
