<?php

declare(strict_types=1);

namespace App\Interface\Http\Controller;

use App\Application\Review\DTO\ReviewRequest;
use App\Application\Review\UseCase\SubmitReviewUseCase;
use App\Interface\Http\Controller\Input\ReviewInput;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/review')]
final class ReviewController extends AbstractController
{
    public function __construct(
        private readonly SubmitReviewUseCase $submitReview,
    ) {
    }

    #[Route(path: '/submit', methods: ['POST'])]
    public function submitReview(#[MapRequestPayload] ReviewInput $input): JsonResponse
    {
        $response = $this->submitReview->execute(new ReviewRequest($input->episodeId, $input->content));

        return $this->json($response);
    }
}
