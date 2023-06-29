<?php

namespace App\Service;

use App\Entity\Country;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class CountryService
{
    private EntityRepository $countryRepository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->countryRepository = $entityManager->getRepository(Country::class);
    }

    public function getTaxPercentage(string $taxNumber): int
    {
        $upperCase = strtoupper($taxNumber);
        $isoCode = substr($upperCase, 0, 2);

        /** @var Country $country */
        $country = $this->countryRepository->findOneBy(['isoCode' => $isoCode]);

        return $country->getTaxPercentage();
    }
}
