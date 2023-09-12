<?php
namespace App\Controller;

use App\Entity\Pokemon;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[AsController]
class IndexController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {}
    
    #[Route(
        name: 'pokemon_get_collection',
        path: '/api/pokemon'
    )]
    public function getCollection()
    {
        $content = $this->dbQuery();
        $response = new StreamedResponse(function () use ($content) {
            $outputStream = fopen('php://output', 'w');    
            fwrite($outputStream, $content);
            fclose($outputStream);
        });
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    private function dbQuery()
    {
        $repository = $this->entityManager->getRepository(Pokemon::class);
        $pokemons = $repository->findBy(['legendary' => false]);
        $serializer = new Serializer(
            [
                new ArrayDenormalizer(),
                new ObjectNormalizer()
            ],
            [new JsonEncoder()]
        );
        return $serializer->serialize($pokemons, 'json');
    }
}