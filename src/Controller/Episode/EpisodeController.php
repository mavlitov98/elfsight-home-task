<?php

declare(strict_types=1);

namespace App\Controller\Episode;

use App\Repository\EpisodeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class EpisodeController extends AbstractController
{
    public function __construct(
        private readonly EpisodeRepository $episodeRepository,
    ) {
    }

    #[Route(path: '/episode/all', methods: ['GET'])]
    public function getAllEpisodes(): JsonResponse
    {
        $episodes = $this->episodeRepository->findAll();

        return $this->json($episodes);
    }
}
