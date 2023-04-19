## Cadastro de Clientes

Cadastro de clientes construído utilizando Laravel, Bootstrap e MySQL.

Tomei a decisão de fazer uma tela única para exibição, consulta, edição, criação e exclusão de clientes.

O projeto em os endpoints para as rotas necessárias para o cadastro do cliente, o arquivo com export da collection todos os endpoints para o Insomnia é o "cadastro_clientes.json" que está na raiz do projeto.

Este projeto Laravel 10.x. Todo os JS e CSS foram implementados pelo pacote `laravel/vite` e compilados com `npm`:

- [Documentação do Laravel 10.x](https://laravel.com/docs/10.x).
- [Guia de uso do Laravel Vite](https://laravel.com/docs/10.x/vite).


## Passo-a-passo para iniciar o projeto

### 1. Baixar o projeto do git
```
// Faça o `git clone` no ambiente desejado
~$ git clone <projeto git>

//Copie e altere o arquivo .env
~$bash cp .env.example .env
~$bash vim .env

    DB_HOST=mysql
    DB_DATABASE=laravel
    DB_USERNAME=root
    DB_PASSWORD=secret

```

### 2. Baixar dependências
```
~$bash npm install
~$bash composer install
~$bash php artisan key:generate
```

### 3. Executar migrations
```
~$bash php artisan migrate
```

### 4. Executar seeders
```
~$bash php artisan db:seed
```

### 5. Executar servidor no ambiente local
```
//Backend - WEB
~$bash php artisan serve

//Backend - API
~$bash php artisan serve --port=8001

//Frontend
~$bash npm run dev
```
