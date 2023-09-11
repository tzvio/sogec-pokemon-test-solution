<?php

namespace App\Command;

use App\Serializer\PokemonNormalizer;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Doctrine\ORM\EntityManagerInterface;

#[AsCommand(
    name: 'app:import:csv',
    description: 'Improt a pokemon list in CSV format to the database',
)]
class ImportCsvCommand extends Command
{

    public function __construct(private readonly EntityManagerInterface $entityManager) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument('file', InputArgument::REQUIRED, 'File to import');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $pokemons = $this->parseCSVFile($input->getArgument('file'));
        $this->saveToDb($pokemons);
        $io = new SymfonyStyle($input, $output);
        $io->success('Succesfully imported csv list.');
        return Command::SUCCESS;
    }

    private function saveToDb($data)
    {
        foreach ($data as $object) {
            $this->entityManager->persist($object);
            $this->entityManager->flush();
        }
    }

    private function parseCSVFile($file) {
        $serializer = new Serializer(
            [
                new ArrayDenormalizer(),
                new PokemonNormalizer()
            ],
            [new CsvEncoder([CsvEncoder::KEY_SEPARATOR_KEY => '*'])]
        );
        $csvData = file_get_contents($file);
        $pokemons = $serializer->deserialize($csvData, 'App\Entity\Pokemon[]', 'csv'); 
        return $pokemons;
    }
}
