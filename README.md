## Task Manager – MVC & CRUD Example

Aplicação web para gerenciamento de tarefas desenvolvida como projeto demonstrativo de arquitetura MVC, operações CRUD e utilizando Laravel.


### Conceitos aplicados
- MVC (Model, View, Controller)
- RESTful Routes
- Eloquent ORM
- Blade Templates


## Visão geral

O Task App é um gerenciador de tarefas no estilo kanban, inspirado em ferramentas como Trello, Linear e Notion.

Permite criar, editar, mover e organizar tarefas de forma fluida, com persistência de estado e interface responsiva.

## Preview

Imagem de capa do projeto:

![Task App Cover](public\docs\cover.png)

Demonstração das principais interações:

Criação e edição inline de tarefas  
![Criando e editando tarefas](public\docs\create-edit.gif)

Drag and drop com persistência de status  
![Drag and drop](public\docs\drag-drop.gif)

Dark mode persistente  
![Dark mode](public\docs\dark-mode.gif)

## Funcionalidades

- Gerenciamento completo de tarefas (CRUD)  
- Criação e edição diretamente no card, sem modais  
- Organização por colunas de status  
- Drag and drop com atualização em tempo real  
- Persistência de status no backend  
- Enum de status no Laravel  
- Prioridades visuais por badge  
- Modo escuro com persistência no navegador  
- Interface responsiva e fluida  
- Feedback visual e transições suaves  

## Tecnologias utilizadas

PHP 8.2  
Laravel 12  
Blade  
JavaScript
Sweet Alert 2
CSS
Bootstrap Icons  
MySQL  

## Arquitetura

O projeto segue o padrão MVC do Laravel:

##### Model  
Responsável pela regra de negócio e casts de dados, incluindo uso de Enum para status.

##### Controller  
Centraliza a lógica de CRUD, validações e atualização de status via requisições assíncronas.

##### View  
Interface construída com Blade, separando layout base, componentes e lógica mínima de exibição.

##### Frontend  
JavaScript desacoplado, responsável por drag and drop, edição inline, dark mode e comunicação com o backend via fetch.

## Estrutura de pastas relevante

app/Enums  
Enum de status da tarefa  

app/Models  
Model Task com casts e fillable  

app/Http/Controllers  
TaskController com CRUD completo e update de status  

resources/views  
Layouts e views do painel kanban  

public/js  
Lógica de frontend desacoplada  

public/css  
Estilos globais da aplicação  

## Como executar o projeto localmente

Clone o repositório

```bash
git clone https://github.com/devyelim/task-app.git
```

Acesse a pasta do projeto

```bash
cd task-app
```

Instale as dependências

```bash
composer install
```

Crie o arquivo de ambiente

```bash
cp .env.example .env
```

Gere a key da aplicação

```bash
php artisan key:generate
```

Configure o banco de dados no `.env` e execute as migrations

```bash
php artisan migrate
```

Inicie o servidor

```bash
php artisan serve
```

Acesse em `http://127.0.0.1:8000`.

## Observações

Este projeto foi desenvolvido com foco em clareza de código, organização e experiência do usuário.
Não utiliza bibliotecas JavaScript externas para drag and drop ou edição inline, priorizando controle total da lógica e entendimento dos fluxos.

É um projeto ideal para fins de estudo, portfólio e demonstração de conhecimento prático em Laravel e frontend moderno.

## Licença

Este projeto é livre para uso educacional e demonstração.
