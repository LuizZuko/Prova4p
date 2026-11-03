# Nexus Games Studio

Sistema web de gerenciamento e consulta de jogos, desenvolvido com Laravel e PostgreSQL. O projeto permite cadastrar, consultar, editar, excluir e pesquisar jogos, além de disponibilizar uma API REST para acesso aos dados.

## Tecnologias utilizadas

- **PHP** – linguagem de programação.
- **Laravel** – framework para desenvolvimento web.
- **PostgreSQL (Neon)** – banco de dados relacional em nuvem.
- **Blade** – mecanismo de templates do Laravel.
- **HTML, CSS e JavaScript** – estrutura, estilização e interatividade.
- **SQLite** – banco de dados isolado para testes automatizados.

## Funcionalidades

- Cadastro de jogos.
- Consulta e visualização de detalhes.
- Edição e exclusão de jogos.
- Upload e exibição de capas dos jogos.
- Pesquisa de jogos pelo título.
- Filtro por categoria.
- Paginação do catálogo.
- Relacionamento entre jogos, categorias e desenvolvedores.
- Interface com tema claro e escuro.
- API REST para consulta e gerenciamento de jogos.

## Estrutura do banco de dados

O projeto possui sete entidades principais:

| Tabela | Descrição |
|---|---|
| jogos | Armazena os jogos cadastrados. |
| categorias | Armazena as categorias dos jogos. |
| desenvolvedores | Armazena os estúdios desenvolvedores. |
| usuarios | Armazena os usuários da plataforma. |
| compras | Registra as compras realizadas. |
| itens_compra | Armazena os itens de cada compra. |
| avaliacoes | Armazena as avaliações dos jogos. |

O projeto utiliza relacionamentos entre as entidades por meio do Eloquent ORM.

## Arquitetura do projeto

O sistema utiliza a organização MVC do Laravel, com uma camada adicional de serviços:

- **Models:** representam as entidades e seus relacionamentos.
- **Views:** apresentam as páginas da aplicação utilizando Blade.
- **Controllers:** recebem as requisições e controlam o fluxo da aplicação.
- **Services:** concentram as operações de gerenciamento dos jogos.
- **API Resources:** padronizam os dados retornados pela API.

## Requisitos

- PHP compatível com a versão do Laravel utilizada.
- Composer.
- Node.js e NPM.
- PostgreSQL ou banco PostgreSQL Neon.
- Extensões PHP necessárias, incluindo PDO PostgreSQL e PDO SQLite para executar os testes.

## Instalação

### 1. Clonar o repositório

```bash
git clone https://github.com/LuizZuko/Prova4p.git
```

### 2. Entrar na pasta do projeto

```bash
cd Prova4p
```

### 3. Instalar as dependências

```bash
composer install
npm install
```

### 4. Criar o arquivo de configuração

No Windows PowerShell:

```powershell
Copy-Item .env.example .env
```

No Linux/macOS:

```bash
cp .env.example .env
```

### 5. Gerar a chave da aplicação

```bash
php artisan key:generate
```

### 6. Configurar o banco de dados

Configure no arquivo `.env` os dados de conexão com o PostgreSQL Neon, incluindo host, porta, nome do banco, usuário, senha e schema utilizado pelo projeto.

Após configurar a conexão, execute as migrations para preparar as tabelas e os objetos SQL:

```bash
php artisan migrate
```

As migrations verificam a estrutura existente e registram sua execução. Caso o banco já possua as tabelas do projeto, elas não serão recriadas.

**Importante:** não utilize `migrate:fresh` em um banco com dados que deseja preservar.


### 7. Criar o link de armazenamento das imagens

```bash
php artisan storage:link
```

### 8. Executar a aplicação

```bash
php artisan serve
```

Em outro terminal, compile os arquivos de frontend:

```bash
npm run dev
```

A aplicação estará disponível em:

http://127.0.0.1:8000

## API REST

A API disponibiliza operações para gerenciamento dos jogos.

| Método | Endpoint | Descrição |
|---|---|---|
| GET | `/api/jogos` | Lista os jogos. |
| POST | `/api/jogos` | Cadastra um jogo. |
| GET | `/api/jogos/{id}` | Consulta um jogo específico. |
| PUT/PATCH | `/api/jogos/{id}` | Atualiza um jogo. |
| DELETE | `/api/jogos/{id}` | Exclui um jogo. |
| POST | `/api/usuarios/{usuario}/carteira/creditos` | Adiciona créditos à carteira. |
| GET | `/api/usuarios/{usuario}/total-gasto` | Consulta o total gasto pelo usuário. |

As respostas da API são disponibilizadas em formato JSON.

## Banco de dados e recursos SQL

O projeto utiliza recursos do PostgreSQL, incluindo:

- Índices para otimização de consultas.
- Funções SQL.
- Stored Procedures.
- Triggers para automatização de operações.

Os scripts SQL estão localizados na pasta `database/sql`:

- `indices.sql`
- `objetos.sql`
- `Verificação.sql`

## Testes automatizados

Os testes são executados utilizando PHPUnit por meio do comando:

```bash
php artisan test
```

O ambiente de testes utiliza SQLite em memória, mantendo os testes isolados do banco PostgreSQL de produção.

Testes implementados:

1. Verificação do redirecionamento da página inicial para o catálogo.
2. Verificação do carregamento do catálogo.
3. Verificação da listagem de jogos pela API em JSON.
4. Verificação dos detalhes de um jogo pela API.

**Resultado atual:** 5 testes aprovados, incluindo o teste unitário padrão do Laravel, com 11 verificações (assertions).

## Backup e restauração

O backup do banco de dados está armazenado em:

`database/backups/nexus.backup`

Para conferir o conteúdo do backup, utilize:

```bash
pg_restore --list database/backups/nexus.backup
```

A restauração deve ser realizada em um banco PostgreSQL compatível. Exemplo de comando:

```bash
pg_restore --clean --if-exists --no-owner --no-privileges -d "SUA_STRING_DE_CONEXAO" database/backups/nexus.backup
```

**Atenção:** faça a restauração em um banco de destino apropriado. A opção `--clean` pode remover objetos existentes antes de restaurá-los. Confira o schema de destino e faça um backup antes de substituir dados.

