<h1 align="center">Gerenciador de Projetos</h1>

## Sobre o projeto

Projeto prático desenhado para dar uma visão de estrutura de código. O objetivo não é criar um produto completo, mas sim mostrar a qualidade, a organização e a profundidade técnica do meu trabalho


## Requisitos do Back-end (Laravel)

1 - Estrutura e Banco de Dados: Versão 12x do Laravel e MySQL.

2 - Models e Relacionamentos:

- Project: com os campos id e name.
- Task: com os campos id, title, completed (boolean), project_id, e um novo campo
difficulty. O campo difficulty deve armazenar a dificuldade da tarefa (ex: baixa, média, alta).
- Relacionamento Eloquent (Project tem muitas Tasks, Task pertence a um Project).

3 - API Endpoints:

- GET /api/projects: Listar todos os projetos.
- GET /api/projects/:id: Retornar os dados do projeto e o campo calculado progress
- POST /api/projects: Criar um novo projeto.
- POST /api/tasks: Criar uma nova tarefa associada a um projeto (deve incluir o campo
difficulty).
- PATCH /api/tasks/:id/toggle: Marcar uma tarefa como concluída ou não.
- DELETE /api/tasks/:id: Excluir uma tarefa.

4 - ⭐ Desa o de Lógica Principal (Progresso Ponderado) ⭐

- O progresso de um projeto deve ser calculado de forma ponderada pelo esforço de cada tarefa.
  - Baixa: 1 ponto de esforço.
  - Média: 4 pontos de esforço.
  - Alta: 12 pontos de esforço.

- Cálculo do Progresso: O progresso do projeto será a porcentagem de tarefas concluídas em
relação ao total de tarefas do projeto, considerando o esforço de cada tarefa nesse cálculo.

## Executar projeto

1 - Utlizei um container docker para instanciar o sail dentro do projeto laravel

```
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php84-composer:latest \
    composer install --ignore-platform-reqs
```

2 - Subir os containers

```./vendor/bin/sail up -d ```

3 - Comandos iniciais

3.1 - Entre no container
```
./vendor/bin/sail exec laravel.service bash
```
3.2 - Dentro do container, execute migrations, seeders e a chave da aplicação
```
php artisan migrate
```
```
php artisan db:seed
```
```
php artisan key:generate
```

A api vai está disponvivel em http://localhost/api