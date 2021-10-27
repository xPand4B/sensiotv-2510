<?php

namespace App\Command;

use App\Helper\OmdbApi;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:imdb',
    description: 'Add a short description for your command',
)]
class ImdbCommand extends Command
{
    private OmdbApi $omdbApi;

    public function __construct(string $name = null, OmdbApi $omdbApi)
    {
        parent::__construct($name);
        $this->omdbApi = $omdbApi;
    }

    protected function configure(): void
    {
        $this->addArgument('name', InputArgument::OPTIONAL, 'Something you want to search.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        if (!$searchName = $input->getArgument('name')) {
            $searchName = $io->ask('What do you want to search?', 'Harry Potter');
        }

        $result = $this->omdbApi->requestAllBySearch($searchName);

        $io->title("Total results for \"${searchName}\":  ${result['totalResults']}");
        $io->table(['Title', 'Release', 'imdbID', 'Type' ], array_map(function($item) {
            return [
                'Title' => $item['Title'],
                'Release' => $item['Year'],
                'imdbID' => "https://www.imdb.com/title/${item['imdbID']}/",
                'Type' => $item['Type'],
            ];
        }, $result['Search']));

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }
}
