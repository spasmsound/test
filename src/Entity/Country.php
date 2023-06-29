<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity]
#[UniqueEntity('name', 'isoCode')]
class Country
{
    use HasId;

    #[ORM\Column(type: 'string')]
    private string $name;

    #[ORM\Column(type: 'string', length: 2)]
    private string $isoCode;

    #[ORM\Column(type: 'string')]
    private string $taxNumberPattern;

    #[ORM\Column(type: 'smallint')]
    private int $taxPercentage = 0;

    public function getIsoCode(): string
    {
        return $this->isoCode;
    }

    public function setIsoCode(string $isoCode): void
    {
        $this->isoCode = $isoCode;
    }

    public function getTaxNumberPattern(): string
    {
        return $this->taxNumberPattern;
    }

    public function setTaxNumberPattern(string $taxNumberPattern): void
    {
        $this->taxNumberPattern = $taxNumberPattern;
    }

    public function getTaxPercentage(): int
    {
        return $this->taxPercentage;
    }

    public function setTaxPercentage(int $taxPercentage): void
    {
        $this->taxPercentage = $taxPercentage;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }
}
