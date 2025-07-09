<?php

declare(strict_types=1);

namespace App\Controller\Review;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

final class ReviewController extends AbstractController
{
    public function __construct()
    {
    }

    #[Route(path: 'review/submit', methods: ['POST'])]
    public function submitReview(): void
    {

    }
}
