# Laravel MySQL API

API de CRUD de usuários desenvolvida em **Laravel 10** com MySQL e Swagger.

## Tecnologias

- PHP 8+
- Laravel 10
- MySQL
- SQLite (para testes em memória)
- Swagger (L5 Swagger)
- PHPUnit
- Laravel Factories

## Requisitos

- PHP 8+
- Composer
- MySQL
- Node.js e NPM (para assets do Laravel, se necessário)
- Extensão PDO MySQL ativada

## Instalação

1. Clone o repositório:

```bash
git clone https://github.com/seu-usuario/laravel-mysql-api.git
cd laravel-mysql-api


Instale as dependências:

composer install


Configure o ambiente:

Configure o ambiente:

cp .env.example .env
php artisan key:generate

Execute as migrations:

php artisan migrate

Rodando o projeto:

php artisan serve


Rodar testes:

php artisan test