# Gabarito — Prova 1 (Iniciante em Laravel)

| Questão | Resposta | Explicação |
|---|---|---|
| 1 | B | Laravel é um framework PHP para construir aplicações web (rotas, controllers, banco de dados, etc.), não um banco, linguagem ou servidor. |
| 2 | B | O Composer é o gerenciador de dependências do PHP. É ele que instala pacotes como `laravel/framework` listados no `composer.json`. |
| 3 | A | Laravel segue o padrão MVC: **Model** (dados/banco), **View** (apresentação) e **Controller** (lógica que liga as duas partes). |
| 4 | B | O `.env` guarda configurações sensíveis e específicas do ambiente (banco de dados, chave da aplicação, mailer, etc.), fora do código-fonte versionado. |
| 5 | A | `php artisan key:generate` gera a `APP_KEY`, usada pelo Laravel para criptografia (sessões, cookies, etc.). |
| 6 | B | `artisan` é a CLI do Laravel: com ele você roda migrations, cria arquivos (controllers, models...), limpa cache, sobe o servidor, etc. |
| 7 | B | `Route::get('/hello', HelloController::class)` registra que requisições GET em `/hello` serão tratadas pelo `HelloController`. |
| 8 | C | `web.php` é voltado a rotas acessadas pelo navegador (com sessão, cookies, CSRF); `api.php` é voltado a rotas stateless, tipicamente consumidas por clientes externos/API. |
| 9 | B | Quando um Controller resolve apenas uma única ação, o Laravel permite usar só o método `__invoke`, dispensando nomear métodos como `index`. É chamado de "single action controller". |
| 10 | C | `response()->json([...])` monta uma resposta HTTP com corpo em JSON e o header `Content-Type: application/json`. |
| 11 | B | A facade `DB` permite executar SQL diretamente (queries, selects, comandos) contra a conexão configurada no `.env` (no caso, PostgreSQL). |
| 12 | B | A função `hello_world()` é criada via SQL puro dentro de uma Migration, usando `DB::unprepared(...)`, que executa comandos SQL que não podem ser "preparados" como statements comuns (ex: `CREATE FUNCTION`). |
| 13 | B | Migration é um arquivo PHP versionado que descreve alterações no schema do banco (criar/alterar tabelas, colunas, funções, etc.), permitindo reproduzir a estrutura do banco em qualquer ambiente. |
| 14 | A | `php artisan migrate` executa todas as migrations que ainda não foram aplicadas ao banco. |
| 15 | B | O prefixo de data/hora no nome do arquivo garante a ordem cronológica de execução das migrations, já que algumas dependem de outras (ex: criar tabela antes de alterar). |
| 16 | B | Laravel Sail é uma CLI leve que facilita gerenciar o ambiente de desenvolvimento Docker (subir containers, rodar comandos artisan/composer dentro deles, etc.). |
| 17 | B | O serviço `pgsql` no `compose.yaml` sobe um container com PostgreSQL, que é o banco de dados configurado em `DB_CONNECTION=pgsql` no `.env`. |
| 18 | B | Eloquent é o ORM do Laravel: permite tratar tabelas do banco como classes PHP (Models), evitando escrever SQL manualmente na maioria dos casos. |
| 19 | B | `app/Http/Controllers` guarda as classes Controller, responsáveis por receber a requisição HTTP (vinda de uma rota) e devolver uma resposta. |
| 20 | B | Fluxo básico: requisição HTTP → arquivo de rotas (`web.php`/`api.php`) → Controller correspondente → lógica (pode envolver Model/DB) → resposta (view ou JSON) devolvida ao cliente. |

---

## Pontuação

- 18 a 20 acertos: excelente domínio dos conceitos iniciais do projeto e do Laravel.
- 14 a 17 acertos: bom entendimento, revise os pontos errados antes de seguir.
- Abaixo de 14: vale reler o `README.md` do projeto e reforçar os conceitos de rotas, controllers e migrations antes da próxima prova.
