<?php

namespace App\DataFixtures;

use App\Entity\Country;
use App\Entity\Coupon;
use App\Entity\Product;
use App\Service\CouponService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function __construct(
        private readonly CouponService $couponService
    )
    {
    }

    /**
     * @throws \Exception
     */
    public function load(ObjectManager $manager): void
    {
        $this->createProducts($manager);
        $this->createCoupons($manager);
        $this->createCountries($manager);

        $manager->flush();
    }

    private function createCountries(ObjectManager $manager): void
    {
        $germany = new Country();
        $germany->setIsoCode('DE');
        $germany->setName('Germany');
        $germany->setTaxNumberPattern('/^DE\d{9}$/');
        $germany->setTaxPercentage(19);

        $manager->persist($germany);

        $italy = new Country();
        $italy->setIsoCode('IT');
        $italy->setName('Italy');
        $italy->setTaxNumberPattern('/^IT\d{11}$/');
        $italy->setTaxPercentage(22);

        $manager->persist($italy);

        $greece = new Country();
        $greece->setIsoCode('GR');
        $greece->setName('Greece');
        $greece->setTaxNumberPattern('/^GR\d{9}$/');
        $greece->setTaxPercentage(24);

        $manager->persist($greece);

        $france = new Country();
        $france->setIsoCode('FR');
        $france->setName('France');
        $france->setTaxNumberPattern('/^FR[a-zA-Z]{2}\d{9}$/');

        $manager->persist($france);
    }

    private function createProducts(ObjectManager $manager): void
    {
        $iphone = new Product();
        $iphone->setTitle('iPhone');
        $iphone->setPrice(10000);

        $manager->persist($iphone);

        $headphones = new Product();
        $headphones->setTitle('Headphones');
        $headphones->setPrice(2000);

        $manager->persist($headphones);

        $case = new Product();
        $case->setTitle('Case');
        $case->setPrice(1000);

        $manager->persist($case);
    }

    /**
     * @throws \Exception
     */
    private function createCoupons(ObjectManager $objectManager): void
    {
        $fixed = new Coupon();
        $fixed->setType(Coupon::TYPE_FIXED);
        $fixed->setValue(2000);
        $fixed->setCode($this->couponService->generateCouponCode());

        $objectManager->persist($fixed);

        $percent = new Coupon();
        $percent->setType(Coupon::TYPE_PERCENT);
        $percent->setValue(10);
        $percent->setCode($this->couponService->generateCouponCode());

        $objectManager->persist($percent);
    }
}
