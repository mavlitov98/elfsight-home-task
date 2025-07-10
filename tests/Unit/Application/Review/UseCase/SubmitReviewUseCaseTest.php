<?php

declare(strict_types=1);

namespace App\Tests\Unit\Application\Review\UseCase;

use App\Application\Review\DTO\ReviewRequest;
use App\Application\Review\DTO\ReviewResponse;
use App\Application\Review\UseCase\SubmitReviewUseCase;
use App\Domain\Review\Service\ReviewServiceInterface;
use Codeception\Test\Unit;

final class SubmitReviewUseCaseTest extends Unit
{
    public function testExecuteDelegatesToServiceAndReturnsResponse(): void
    {
        $request = new ReviewRequest(episodeId: 1, content: 'Great episode!');
        $expectedResponse = new ReviewResponse(message: 'Review submitted');

        $service = $this->createMock(ReviewServiceInterface::class);
        $service
            ->expects($this->once())
            ->method('submit')
            ->with($request)
            ->willReturn($expectedResponse);

        $useCase = new SubmitReviewUseCase($service);

        $actualResponse = $useCase->execute($request);

        $this->assertSame($expectedResponse, $actualResponse);
    }
}
