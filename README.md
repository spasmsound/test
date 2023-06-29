How to build:
1. cp .env .env.local
2. Update DATABASE_URL variable value
3. cd docker
4. cp .env.dist .env
5. bin/build.sh
6. bin/up.sh
7. bin/enter.sh php
8. composer install
9. bin/console doctrine:migrations:migrate
10. bin/console doctrine:fixtures:load
    
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
