# AI-Butler

Osobní AI asistent – pošta, rozvrh, úkoly, výkazy, znalosti.

## Stack

- Laravel 13, PHP 8.5
- [steelants/laravel-boilerplate](https://github.com/steelants/Laravel-Boilerplate) – layout, navigace, Bootstrap 5, Livewire 3

## Struktura

- `src/` – Laravel aplikace

## Vývoj

```bash
cd src
composer install
npm install
cp .env.example .env && php artisan key:generate
php artisan migrate
npm run dev & php artisan serve
```
