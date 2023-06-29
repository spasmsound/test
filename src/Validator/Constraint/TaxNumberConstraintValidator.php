<?php

namespace App\Validator\Constraint;

use App\Entity\Country;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class TaxNumberConstraintValidator extends ConstraintValidator
{
    private EntityRepository $countryRepository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->countryRepository = $entityManager->getRepository(Country::class);
    }

    public function validate(mixed $value, Constraint $constraint): void
    {
        $upperCase = strtoupper($value);
        $isoCode = substr($upperCase, 0, 2);

        /** @var ?Country $country */
        $country = $this->countryRepository->findOneBy(['isoCode' => $isoCode]);

        if (is_null($country)) {
            $this
                ->context
                ->buildViolation('Country "' . $isoCode . '" not found in the database')
                ->addViolation();

            return;
        }

        $regexPattern = $country->getTaxNumberPattern();

        if (1 !== preg_match($regexPattern, $upperCase)) {
            $this
                ->context
                ->buildViolation('Invalid tax number for ' . $country->getName())
                ->addViolation();
        }
    }
}
