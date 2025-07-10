<?php

declare(strict_types=1);

namespace App\Infrastructure\CLI;

use App\Application\Episode\UseCase\FetchAllEpisodesUseCase;
use Override;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand('cli:episodes:fetch')]
final class FetchEpisodesCommand extends Command
{
    public function __construct(
        private readonly FetchAllEpisodesUseCase $fetchAllEpisodes,
    ) {
        parent::__construct();
    }

    #[Override]
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $style = new SymfonyStyle($input, $output);
        $style->note('Fetching episodes...');

        $count = $this->fetchAllEpisodes->execute();

        if (0 === $count) {
            $style->error('No episodes found.');

            return self::FAILURE;
        }

        $style->success("Fetched {$count} episodes successfully.");

        return self::SUCCESS;
    }
}
