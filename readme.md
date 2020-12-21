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

## Informações gerais

Este projeto consiste em uma API para simular operações básicas de um caixa eletrônico.

Sendo elas:

- Possibilidade de cadastrar, alterar, excluir e buscar usuários. Os atributos para usuário precisam ser nome, data de nascimento e cpf.
- Possibilidade de cadastrar contas para usuários com tipo da conta (poupança ou corrente) e saldo.
- O usuário poderá fazer depósito de qualquer valor em sua conta, exceto centavos.
- O usuário poderá fazer saque de sua conta apenas utilizando as notas de 20, 50 ou 100.

As tecnologias utilizados nesse projeto foram:
- [PHP 7.2](https://www.php.net/releases/7_2_0.php)
- [Laravel 5.8](https://laravel.com/docs/5.8/)
- [MYSQL 5.7](https://dev.mysql.com/doc/refman/5.7/en/)
- [Docker](https://phpdocker.io/)

## Começando

Na sua máquina, você só precisa ter o [Git](https://git-scm.com/book/en/v2/Getting-Started-Installing-Git), o [Docker](https://www.docker.com/get-started) e o [Docker Compose](https://docs.docker.com/compose/) instalados.

- Clone este repositório rodando o comando abaixo:
```bash
git clone https://github.com/FernandoNakatsu/atm-simulator.git atm-simulator
```
- Crie um arquivo **.env** na raíz do projeto.
- Copie todo conteúdo do arquivo **.env.example** no arquivo **.env** criado.

Você pode subir o projeto utilizando o `docker-compose`.
Garanta que a porta `8080` de sua máquina não esteja sendo utilizada e rode o comando abaixo:

```bash
docker-compose up -d
```

Em seguida, será necessário instalar as dependências do projeto:

```bash
docker-compose exec php-fpm composer install
```

Crie as tabelas necessárias do projeto rodando o comando abaixo:

```bash
docker-compose exec php-fpm php artisan migrate
```

A partir daqui, está tudo configurado.

Assim, será possível acessar [http://localhost:8080](http://localhost:8080) e ver a documentação da API.

## Testes

Para rodar os testes da aplicação, utilize o [phpunit](https://phpunit.de/), que já vem instalado:

```bash
docker-compose exec php-fpm vendor/bin/phpunit
```

