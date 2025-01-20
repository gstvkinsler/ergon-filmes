# Aplicação de Recomendação de Séries e Filmes

## Pré-requisitos do sistema
- PHP (>= 8.1)
- Composer
- MySQL
- Node.js (>= 16.x)

## Sobre o Projeto
Este é um sistema de recomendação de séries e filmes onde usuários podem:
- Criar posts com recomendações de séries ou filmes.
- Interagir com os posts de outros usuários, votando ou seguindo.
- Acompanhar feeds personalizados

## Tecnologias Utilizadas
- **Framework**: Laravel 11(PHP)
- **Banco de Dados**: MySQL

## Funcionalidades
1. Autenticação de usuários.
2. CRUD de posts (séries/filmes).
3. Interações com posts (votar e seguir).
4. Feeds:
   - Central (todos os posts ativos).
   - Seguidos (posts acompanhados pelo usuário).


## Instale as dependências:
- Execute o comando "composer install" via terminal.

## Renomear env.
- Execute o comando "cp .env.example .env" via terminal.

## Gerar chave da aplicação
- Execute o comando "php artisan key:generate" via terminal.

## Execute as migrações
- Execute o comando "php artisan migrate" via terminal.

## Instale as dependecias npm
- Execute o comando "npm install" via terminal.

## Execute a aplicação 
- Execute o comando "php artisan serve" via terminal.

## Execute o front-end

- Execute o comando "npm run dev" via terminal
