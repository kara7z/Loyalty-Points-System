# ShopEasy — MVC + Twig (Basics) — Better UI + Real Image Links + Auth-first

What you get:
- Clean MVC structure (Models + Services + Controllers + Twig views)
- Better basic CSS (no framework)
- Product catalog with **valid image links** (Wikimedia Commons)
- Cart + fake checkout/payment (simulation only)
- Loyalty points (10 points per 100$) + rewards + points history
- **Auth-first UX**: user must login/register to access products

## Requirements
- PHP 7.4+ (tested on PHP 8.x)
- MySQL
- Composer

## Setup
1) Create DB (example `shopeasy`) and import:
- `sql/schema.sql`
- `sql/seed.sql`

2) Configure DB in `config/database.php`

3) Install deps:
```bash
composer install
composer dump-autoload -o
```

## Run (PHP built-in)
```bash
php -S localhost:8000 -t public public/router.php
```

Open:
- http://localhost:8000/  (redirects to login, then products after login)

## Routes
Public:
- GET/POST /login
- GET/POST /register

Protected (must be logged in):
- /products
- /cart
- /checkout + /checkout/success
- /dashboard
- /points/history
- /rewards + POST /rewards/redeem/{id}
