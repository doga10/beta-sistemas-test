<p align="center"><img src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg" width="400"></p>


## Beta Sistemas - API REST

Requisitos da API:

- PHP >= 7.2.
- Laravel >= 7.*.
- MySQL = 5.7
- Composer

OU 

- Docker >= 19.*
- docker-compose >= 1.25.*

## Subindo ambiente

###### Comandos para ambiente sem docker:

- `composer install`

- `cp .env.local .env`. Apois isso configure suas variaveis de ambiente.

- `php artisan migrate`

- `php artisan passport:install`

- `vendor/bin/phpunit`

- `php artisan serve`

Aposta subir o servidor Laravel, vá ao endereço `http://localhost:8000/swagger/index.html` e lá vai estar a docs da API

###### Comandos para ambiente docker:

- `cp .env.example .env`

- `composer install`

- `docker-compose up --build`

- `docker-compose exec db bash`

apois rodar o comando `docker-compose exec db bash` você irá entrar no shell do container do mysql.

- `mysql -u root -p` a senha definida no exemplo é root adicione ela apois rodar o comando.

- `GRANT ALL ON laravel.* TO 'laraveluser'@'%' IDENTIFIED BY 'root';`

- `FLUSH PRIVILEGES;` esses 2 comandos anteriores irá criar o usuario `laraveluser` no banco de dados com a senha `root`

- `exit`

- `exit` os 2 `exit` vai ser para sair do mysql e do container do mysql

- `docker-compose exec app php artisan key:generate`

- `docker-compose exec app php artisan config:cache`

- `docker-compose exec app php artisan migrate:reset`

- `docker-compose exec app php artisan passport:install`

Aposta todos os comandos retornarem OK, vá ao endereço `http://localhost/swagger/index.html` e lá vai estar a docs da API
