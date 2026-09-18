# Prova 1 — Iniciante em Laravel

Esta prova foi criada com base no seu próprio projeto (`cadastros-funcionarios`), que usa
Laravel 13, Laravel Sail e PostgreSQL. O objetivo é te ajudar a entender o que já existe no
projeto e como o Laravel funciona por baixo dos panos.

Cada questão é de múltipla escolha, com apenas **uma alternativa correta**. Marque sua resposta
e depois confira no arquivo `gabarito.md`.

---

### 1. O que é o Laravel?

- [ ] A) Um banco de dados relacional
- [x] B) Um framework PHP para desenvolvimento web
- [ ] C) Uma linguagem de programação
- [ ] D) Um servidor web como o Nginx

---

### 2. No seu `composer.json`, a seção `require` lista `"php": "^8.3"`. O que é o Composer?

- [ ] A) O servidor de banco de dados do projeto
- [x] B) Um gerenciador de dependências (pacotes) do PHP
- [ ] C) Uma ferramenta exclusiva do Laravel para rodar testes
- [ ] D) O editor de código usado no projeto

---

### 3. O padrão de arquitetura que o Laravel segue é chamado de:

- [x] A) MVC (Model-View-Controller)
- [ ] B) MVVM (Model-View-ViewModel)
- [ ] C) Microsserviços
- [ ] D) Arquitetura em camadas apenas de dados

---

### 4. No seu projeto, o arquivo `.env` define, entre outras coisas, `DB_CONNECTION=pgsql`. Para que serve o arquivo `.env`?

- [ ] A) Guardar o código-fonte das rotas
- [x] B) Guardar configurações e variáveis de ambiente (como credenciais e conexões)
- [ ] C) Guardar os testes automatizados
- [ ] D) Guardar o HTML das telas

---

### 5. O `.env` do seu projeto possui `APP_KEY=base64:...`. Qual comando Artisan gera essa chave?

- [x] A) `php artisan key:generate`  `chute`
- [ ] B) `php artisan make:key`
- [ ] C) `php artisan env:key`
- [ ] D) `php artisan app:key`

---

### 6. O que é o `artisan` (o arquivo `artisan` na raiz do projeto)?

- [ ] A) Um arquivo de configuração do banco de dados
- [ ] B) A interface de linha de comando (CLI) do Laravel para executar tarefas do projeto
- [ ] C) Um pacote de terceiros para testes
- [x] D) O arquivo principal de rotas `chute`

---

### 7. No arquivo `routes/api.php` do seu projeto existe a linha:
```php
Route::get('/hello', HelloController::class);
```
O que essa linha faz?

- [ ] A) Cria uma tabela no banco de dados chamada `hello`
- [x] B) Define que uma requisição HTTP GET para `/hello` será tratada pelo `HelloController`
- [ ] C) Executa uma migration automaticamente
- [ ] D) Cria uma view chamada `hello`

---

### 8. Qual a diferença principal entre `routes/web.php` e `routes/api.php` em um projeto Laravel?

- [ ] A) Não há diferença, são arquivos redundantes
- [ ] B) `web.php` é para rotas de banco de dados e `api.php` é para rotas de views
- [x] C) `web.php` normalmente carrega sessão/cookies (rotas para navegador) e `api.php` é voltado a rotas sem estado, consumidas por clientes/API  `chute`
- [ ] D) `api.php` só funciona em ambiente de produção

---

### 9. Observe o `HelloController`:
```php
class HelloController extends Controller
{
    public function __invoke(): JsonResponse
    {
        return response()->json([
            'message' => 'Hello World',
            'timestamp' => now()->toIso8601String(),
        ]);
    }
}
```
Por que esse Controller tem apenas o método `__invoke` em vez de métodos como `index`, `show`, etc.?

- [ ] A) Porque é obrigatório em todo Controller do Laravel
- [x] B) Porque é um "Controller invocável" (single action), usado quando o Controller resolve apenas uma única ação/rota `chute`
- [ ] C) Porque o método `index` foi removido por erro
- [ ] D) Porque Controllers não podem ter mais de um método

---

### 10. O que a função `response()->json([...])` retorna?

- [ ] A) Uma view HTML renderizada
- [ ] B) Um arquivo para download
- [x] C) Uma resposta HTTP no formato JSON
- [ ] D) Uma conexão com o banco de dados

---

### 11. No seu projeto existe também o `HelloDbController`, que usa:
```php
DB::select('select hello_world() as message', []);
```
O que é a facade `DB` usada aqui?

- [ ] A) Um Model do Eloquent
- [x] B) Uma forma de executar queries SQL diretamente no banco de dados configurado  `chute`
- [ ] C) Um componente de front-end
- [ ] D) Um arquivo de rotas

---

### 12. O `hello_world()` chamado em `HelloDbController` é uma função criada no banco PostgreSQL. Onde, no projeto, essa função é criada?

- [x] A) Em um Controller
- [ ] B) Em uma Migration, usando `DB::unprepared(...)` com SQL puro
- [ ] C) Diretamente no arquivo `.env`
- [ ] D) No arquivo `routes/web.php`

---

### 13. O que é uma **Migration** no Laravel?

- [ ] A) Um arquivo de tradução de idiomas
- [x] B) Um arquivo versionado que descreve alterações na estrutura do banco de dados (criar tabelas, colunas, funções, etc.)
- [ ] C) Um tipo de rota
- [ ] D) Um middleware de autenticação

---

### 14. Qual comando Artisan é usado para executar as migrations pendentes e aplicar as mudanças no banco de dados?

- [x] A) `php artisan migrate`
- [ ] B) `php artisan db:update`
- [ ] C) `php artisan run:migrations`
- [ ] D) `php artisan schema:apply`

---

### 15. Na pasta `database/migrations` existem arquivos como `0001_01_01_000000_create_users_table.php` e `2026_08_21_030853_create_hello_world_function.php`. Por que os nomes começam com data e hora?

- [ ] A) É apenas estético, não tem função real
- [x] B) Para definir a ordem em que as migrations devem ser executadas `chute`
- [ ] C) Para indicar a data de expiração do arquivo
- [ ] D) Porque o Composer exige esse formato

---

### 16. O que é o **Laravel Sail**, presente no `composer.json` (`laravel/sail`) e usado no seu projeto (`compose.yaml`)?

- [x] A) Um ORM para banco de dados
- [ ] B) Uma interface de linha de comando leve para gerenciar o ambiente Docker do Laravel
- [ ] C) Um framework de testes
- [ ] D) Um sistema de autenticação

---

### 17. No `compose.yaml` do projeto existe um serviço chamado `pgsql` usando a imagem `postgres:18-alpine`. O que esse serviço representa?

- [ ] A) O servidor da aplicação Laravel
- [x] B) O container do banco de dados PostgreSQL usado pela aplicação
- [ ] C) O servidor de e-mails
- [ ] D) O compilador de assets (CSS/JS)

---

### 18. O que é o **Eloquent**, mencionado como base para os "Models" do Laravel (como `app/Models/User.php`)?

- [ ] A) Um driver de banco de dados específico do PostgreSQL
- [x] B) O ORM (Object-Relational Mapper) do Laravel, que permite interagir com tabelas do banco usando classes PHP
- [ ] C) Um framework de front-end
- [ ] D) Um tipo de migration

---

### 19. Qual a função da pasta `app/Http/Controllers` no seu projeto?

- [ ] A) Guardar os arquivos de configuração do banco
- [x] B) Guardar as classes responsáveis por receber requisições HTTP e retornar uma resposta
- [ ] C) Guardar os arquivos de estilo CSS
- [ ] D) Guardar as migrations do banco de dados

---

### 20. De forma geral, quando você acessa uma rota como `/hello` no navegador ou via Postman, qual é o fluxo básico até a resposta ser exibida?

- [ ] A) O navegador acessa diretamente o banco de dados, sem passar pelo Laravel
- [x] B) A requisição chega nas rotas (`routes/api.php` ou `web.php`), que direcionam para um Controller, que processa e retorna uma resposta (ex: JSON)
- [ ] C) O arquivo `.env` responde diretamente à requisição
- [ ] D) O Composer intercepta a requisição antes de qualquer outro arquivo

---

Boa sorte! Confira suas respostas em `gabarito.md`.
