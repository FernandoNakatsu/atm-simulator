<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg" width="400"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>


<div align="center">
    <h1 align="center">Simulador Caixa Eletrônico</h1>
</div>

## Informações gerais de ambiente

Este projeto consiste em uma API para simular operações básicas de um caixa eletrônico.

Sendo elas:

- Possibilidade de cadastrar, alterar, excluir e buscar usuários. Os atributos para usuário precisam ser nome, data de nascimento e cpf.
- Possibilidade de cadastrar contas para usuários com tipo da conta (poupança ou corrente) e saldo.
- O usuário poderá fazer depósito de qualquer valor em sua conta, exceto centavos.
- O usuário poderá fazer saque de sua conta apenas utilizando as notas de 20, 50 ou 100.

As técnologias utilizados nessa aplicação foram [PHP 7.2](https://www.php.net/releases/7_2_0.php), [Laravel 5.8](https://laravel.com/docs/5.8/), [MYSQL 5.7](https://dev.mysql.com/doc/refman/5.7/en/) e [Docker](https://phpdocker.io/).

## Começando

- Clone este repositório.
- Crie um arquivo **.env** na raíz do projeto.
- Copie todo conteúdo do arquivo **.env.example** no arquivo **.env** criado.

Na sua máquina, você só precisa ter o [Docker](https://www.docker.com/get-started) e o [Docker Compose](https://docs.docker.com/compose/) instalados.
Você pode subir o projeto utilizando o `docker-compose`.
Garanta que a porta `80` de sua máquina não esteja sendo utilizada e rode o comando abaixo:

```bash
docker-compose up -d
```

Em seguida, será necessário instalar as dependências do projeto:

```bash
docker-compose exec php-fpm composer install
```

E por fim, para criar as tabelas necessárias na base de dados, rode o comando abaixo:

```bash
docker-compose exec php-fpm php artisan migrate
```

## Testes

Para rodar os testes da aplicação, utilize o [phpunit](https://phpunit.de/), que já vem instalado:

```bash
docker-compose exec php-fpm vendor/bin/phpunit
```

