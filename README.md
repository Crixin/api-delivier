<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Passo a passo para rodar a aplicação
Para executar a aplicação de forma correta é necessário executar os passos a seguir na ordem descrita:

    cp .env.example .env
    composer install
	docker-compose up -d --build
    docker-compose exec web bash

Os comandos a seguir devem ser executados dentro do terminal bash que acabou de abrir com o comando anterior.

	php artisan key:generate
    php artisan migrate
    chmod  777 -R /var/www/storage/

Depois de rodar os comandos pode fechar o terminal e acessar a sua máquina na porta 8000 que a api estará rodando!

Para testar a API existe um arquivo chamado `Insomnia_api.json` que contém todos os métodos disponíveis para utilizar com o Insomnia.


