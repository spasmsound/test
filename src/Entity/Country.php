<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Country
{
    use HasId;

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
}
