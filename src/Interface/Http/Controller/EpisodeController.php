<?php

declare(strict_types=1);

namespace App\Interface\Http\Controller;

use App\Application\Episode\UseCase\GetAllEpisodesUseCase;
use App\Application\Episode\UseCase\GetEpisodeSummaryUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/episode')]
final class EpisodeController extends AbstractController
{
    public function __construct(
        private readonly GetAllEpisodesUseCase $getAllEpisodes,
        private readonly GetEpisodeSummaryUseCase $getSummary,
    ) {
    }

    #[Route(path: '/all', methods: ['GET'])]
    public function getAllEpisodes(): JsonResponse
    {
        $episodes = $this->getAllEpisodes->execute();

        return $this->json($episodes);
    }

    #[Route('/{id}/summary', methods: ['GET'])]
    public function getEpisodeSummary(int $id): JsonResponse
    {
        $summary = $this->getSummary->execute($id);

        if (null === $summary) {
            return $this->json(['error' => 'Episode not found'], 404);
        }

        return $this->json($summary);
    }
}
