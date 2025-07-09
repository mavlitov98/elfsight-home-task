<?php

declare(strict_types=1);

namespace App\Controller\Review;

use App\Controller\Review\Input\ReviewInput;
use App\Service\Review\ReviewRequest;
use App\Service\Review\ReviewServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

final class ReviewController extends AbstractController
{
    public function __construct(
        private readonly ReviewServiceInterface $reviewService,
    ) {
    }

    #[Route(path: '/review/submit', methods: ['POST'])]
    public function submitReview(#[MapRequestPayload] ReviewInput $input): JsonResponse
    {
        $response = $this->reviewService->submit(new ReviewRequest($input->episodeId, $input->content));

        return $this->json(['message' => $response->message]);
    }
}
