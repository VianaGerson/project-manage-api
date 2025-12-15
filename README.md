<h1 align="center">Gerenciador de Projetos - Backend (Laravel)</h1>

## 🎯 Sobre o Projeto

Este projeto prático é uma demonstração de **proficiência técnica**, **organização de código** e **estrutura de software robusta**.

O objetivo primário é ir além da funcionalidade básica, focando na **qualidade arquitetural**.

### 🏗️ Padrão Service Repository

Para garantir a **separação de responsabilidades** (SoC) e facilitar a manutenção e escalabilidade, o projeto adota o padrão **Service Repository**.

* **Repository:** Responsável pela abstração da camada de persistência de dados (CRUD).
* **Service:** Contém a lógica de negócio principal, orquestrando as operações dos Repositórios.

Essa arquitetura visa a expansão futura e a modularização, permitindo uma eventual transição para uma arquitetura de microserviços, se necessário.

> **⚠️ Observação Arquitetural Futura:**
> Por questões de tempo, a organização da lógica de negócio principal foi implementada no padrão Service. No entanto, o objetivo é adotar o pacote **`lorisleiva/laravel-actions`** para encapsular ações e comandos, garantindo uma organização ainda mais granular, testável e explícita do código. Esta refatoração será a próxima etapa para o portfólio.

---

## 🛠️ Requisitos do Back-end (Laravel)

### 1. Estrutura e Tecnologia

* **Framework:** Laravel (Versão 12.x)
* **Banco de Dados:** MySQL

### 2. Modelagem de Dados

O banco de dados é composto por duas entidades principais com relacionamento One-to-Many:

| Model | Campos Principais | Relacionamento |
| :--- | :--- | :--- |
| **Project** | `id`, `name` | Possui muitas Tasks (`hasMany`) |
| **Task** | `id`, `title`, `completed` (boolean), `project_id` (FK), `difficulty` (string) | Pertence a um Project (`belongsTo`) |

> O campo `difficulty` armazena o nível de esforço da tarefa: **Baixa**, **Média** ou **Alta**.

### 3. API Endpoints

A API RESTful é implementada com os seguintes endpoints:

| Método | Endpoint | Descrição |
| :--- | :--- | :--- |
| `GET` | `/api/projects` | Lista todos os projetos. |
| `GET` | `/api/projects/{id}` | Retorna os dados do projeto, **incluindo o campo calculado `progress`**. |
| `POST` | `/api/projects` | Cria um novo projeto. |
| `POST` | `/api/tasks` | Cria uma nova tarefa, associando-a a um projeto e definindo o campo `difficulty`. |
| `PATCH` | `/api/tasks/{id}/toggle` | Altera o status da tarefa para concluída ou não concluída. |
| `DELETE` | `/api/tasks/{id}` | Exclui uma tarefa. |

### 4. ⭐ Lógica Principal: Progresso Ponderado ⭐

O progresso (`progress`) de um projeto não é um simples cálculo de tarefas concluídas, mas sim um cálculo **ponderado pelo esforço (dificuldade)** de cada tarefa.

#### Pontuação de Esforço:

* **Baixa:** 1 ponto de esforço
* **Média:** 4 pontos de esforço
* **Alta:** 12 pontos de esforço

#### Fórmula de Cálculo:

O progresso é a porcentagem da soma total dos pontos de esforço das tarefas concluídas em relação à soma total dos pontos de esforço de *todas* as tarefas do projeto.

---

## ⚙️ Como Executar o Projeto

Utilizamos o **Laravel Sail** (uma interface de linha de comando leve para interagir com a configuração Docker padrão do Laravel) para garantir um ambiente de desenvolvimento consistente.

1.  **Instalação das Dependências (via Docker):**
    ```bash
    docker run --rm \
        -u "$(id -u):$(id -g)" \
        -v "$(pwd):/var/www/html" \
        -w /var/www/html \
        laravelsail/php84-composer:latest \
        composer install --ignore-platform-reqs
    ```

2.  **Subir os Containers (Sail):**
    ```bash
    ./vendor/bin/sail up -d 
    ```

3.  **Comandos de Inicialização da Aplicação:**

    3.1. **Acessar o Container de Serviço:**
    ```bash
    ./vendor/bin/sail exec laravel.service bash
    ```

    3.2. **Dentro do Container, executar Migrations, Seeders e gerar a chave:**
    ```bash
    php artisan migrate --seed
    php artisan key:generate
    ```

### 🌍 Acesso à API

A aplicação estará acessível através da seguinte URL:
**[http://localhost/api](http://localhost/api)**