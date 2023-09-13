<?php

namespace App\Entity;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Put;
use Doctrine\DBAL\Types\Types;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\PokemonRepository;
use App\State\PokemonRemoveProcessor;
use ApiPlatform\Metadata\GetCollection;
use App\Validator\Constraints\PointsLimit;
use App\Validator\Constraints\AssertCanDelete;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Doctrine\Orm\Filter\BooleanFilter;

#[ORM\Entity(repositoryClass: PokemonRepository::class)]
#[ApiResource(
    operations:[
    new GetCollection(paginationItemsPerPage: 50),
    new Get(),
    new Patch(security: "is_granted('ROLE_USER')"),
    new Delete(security: "is_granted('ROLE_USER')", validationContext:['groups' => ['deleteValidation']], processor: PokemonRemoveProcessor::class )
    ])
]
#[ApiFilter(
    SearchFilter::class, 
    properties: ['name' => 'partial', 'type1' => 'exact', 'type2' => 'exact', 'generation' => 'exact'])]
#[ApiFilter(BooleanFilter::class, properties: ['legendary'])]
#[PointsLimit]
#[AssertCanDelete(groups: ['deleteValidation'])]
class Pokemon
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $type1 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $type2 = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $total = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $hp = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $attack = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $defense = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $spatk = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $spdef = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $speed = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $generation = null;

    #[ORM\Column(type: Types::BOOLEAN) ]
    private ?bool $legendary = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getType1(): ?string
    {
        return $this->type1;
    }

    public function setType1(?string $type1): static
    {
        $this->type1 = $type1;

        return $this;
    }

    public function getType2(): ?string
    {
        return $this->type2;
    }

    public function setType2(?string $type2): static
    {
        $this->type2 = $type2;

        return $this;
    }

    public function getTotal(): ?int
    {
        return $this->total;
    }

    public function setTotal(int $total): static
    {
        $this->total = $total;

        return $this;
    }

    public function getHp(): ?int
    {
        return $this->hp;
    }

    public function setHp(int $hp): static
    {
        $this->hp = $hp;

        return $this;
    }

    public function getAttack(): ?int
    {
        return $this->attack;
    }

    public function setAttack(int $attack): static
    {
        $this->attack = $attack;

        return $this;
    }

    public function getDefense(): ?int
    {
        return $this->defense;
    }

    public function setDefense(int $defense): static
    {
        $this->defense = $defense;

        return $this;
    }

    public function getSpatk(): ?int
    {
        return $this->spatk;
    }

    public function setSpatk(int $spatk): static
    {
        $this->spatk = $spatk;

        return $this;
    }

    public function getSpdef(): ?int
    {
        return $this->spdef;
    }

    public function setSpdef(int $spdef): static
    {
        $this->spdef = $spdef;

        return $this;
    }

    public function getSpeed(): ?int
    {
        return $this->speed;
    }

    public function setSpeed(int $speed): static
    {
        $this->speed = $speed;

        return $this;
    }

    public function getGeneration(): ?int
    {
        return $this->generation;
    }

    public function setGeneration(int $generation): static
    {
        $this->generation = $generation;

        return $this;
    }

    public function isLegendary(): ?bool
    {
        return $this->legendary;
    }

    public function setLegendary(bool $legendary): static
    {
        $this->legendary = $legendary;

        return $this;
    }
}
