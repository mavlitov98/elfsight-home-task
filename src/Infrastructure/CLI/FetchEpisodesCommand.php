<?php

declare(strict_types=1);

namespace App\Infrastructure\CLI;

use App\Application\Episode\UseCase\FetchAllEpisodesUseCase;
use App\Domain\Episode\Entity\Episode;
use App\Domain\Episode\Repository\EpisodeRepositoryInterface;
use DateTimeImmutable;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand('cli:episodes:fetch')]
final class FetchEpisodesCommand extends Command
{
    public function __construct(
        private readonly FetchAllEpisodesUseCase $fetchAllEpisodes,
        private readonly EpisodeRepositoryInterface $episodeRepository,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $episodes = $this->fetchAllEpisodes->execute();
        $style = new SymfonyStyle($input, $output);

        if (empty($episodes)) {
            $style->error('No episodes found.');

            return self::FAILURE;
        }

        $progressBar = new ProgressBar($output, count($episodes));
        $progressBar->start();

        $this->episodeRepository->deleteAll();
        foreach ($episodes as $episode) {
            $entity = new Episode(
                id: $episode->id,
                name: $episode->name,
                date: new DateTimeImmutable($episode->releaseDate),
            );

            $this->episodeRepository->add($entity);
            $progressBar->advance();
        }

        $this->episodeRepository->flush();
        $progressBar->finish();
        $style->success('All episodes fetched successfully!');

        return self::SUCCESS;
    }
}
