How to build:
1. cp .env .env.local
2. cd docker
3. cp .env.dist .env
4. bin/build.sh
5. bin/up.sh
6. bin/enter.sh php
7. composer install
8. bin/console doctrine:migrations:migrate
9. bin/console doctrine:fixtures:load
    
Endpoints:
1. POST /products/calculate-price
Example request:
{
    "product": 1,
    "taxNumber": "GR123456789",
    "couponCode": "CX47",
    "paymentProcessor": "paypal"
}

2. POST /products/buy
Example request:
{
    "product": 1,
    "taxNumber": "GR123456789",
    "couponCode": "CX47",
    "paymentProcessor": "paypal",
		"amount": 100
}

P.S. Implemented everything except PHPUnit tests, I just did not have enough free time for that
