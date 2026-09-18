# Prova 2 — Intermediário (Versionamento de Procedures)

Esta prova foi criada com base no que você acabou de construir no projeto
`cadastros-funcionarios`: a infraestrutura própria de versionamento de stored
procedures/functions do PostgreSQL (`schema_procedures`, pasta
`database/procedures/`, comandos `procedures:migrate` e `procedures:status`).

Cada questão é de múltipla escolha, com apenas **uma alternativa correta**. Marque sua
resposta (troque `[ ]` por `[x]` na alternativa escolhida) e depois confira no arquivo
`gabarito.md`.

---

### 1. Por que o projeto criou um mecanismo próprio de versionamento de procedures, em vez de colocar `CREATE FUNCTION` direto nas migrations do Laravel?

- [ ] A) Porque o Laravel não permite `DB::unprepared` em migrations
- [ ] B) Para separar a criação de **estrutura** (tabelas, migrations) da criação de **lógica de banco** (procedures/functions), com um histórico e controle próprios
- [ ] C) Porque o PostgreSQL não aceita functions dentro de migrations
- [ ] D) Para deixar o projeto mais lento de propósito

---

### 2. Qual é o papel da tabela `schema_procedures`?

- [ ] A) Armazenar os dados da aplicação, como um cadastro de funcionários
- [ ] B) Substituir a tabela `migrations` do Laravel
- [ ] C) Registrar quais versões de procedure já foram aplicadas neste ambiente (nome, versão, checksum, data e usuário)
- [ ] D) Guardar o código-fonte de todos os Controllers

---

### 3. No padrão de nome `V001__create_proc_hello_world.sql`, o que o número `001` representa?

- [ ] A) A quantidade de tabelas afetadas pelo arquivo
- [ ] B) A versão sequencial daquele arquivo de procedure, usada para definir ordem e identidade única
- [ ] C) O ID do usuário que criou o arquivo
- [ ] D) A porta em que o PostgreSQL está rodando

---

### 4. O que é o `checksum` armazenado em `schema_procedures` para cada versão aplicada?

- [ ] A) A senha de acesso ao banco de dados
- [ ] B) Um hash calculado sobre o conteúdo do arquivo .sql, usado para detectar se ele foi alterado depois de aplicado
- [ ] C) O tempo (em milissegundos) que o comando levou para aplicar a procedure
- [ ] D) O número da migration mais recente do Laravel

---

### 5. Você aplicou a versão `V001` e, depois, editou o conteúdo desse mesmo arquivo `V001__create_proc_hello_world.sql` (sem criar um `V002`). O que acontece ao rodar `php artisan procedures:migrate` de novo?

- [ ] A) O comando aplica a alteração silenciosamente, atualizando a function no banco
- [ ] B) O comando ignora o arquivo alterado e segue em frente normalmente
- [ ] C) O comando detecta que o checksum não bate com o registrado, recusa aplicar e orienta a criar uma nova versão (ex: `V002`)
- [ ] D) O comando apaga o arquivo automaticamente

---

### 6. Por que **não é permitido** editar silenciosamente um arquivo de procedure já aplicado, mesmo que a mudança pareça pequena?

- [ ] A) Porque arquivos `.sql` não podem ser editados no sistema operacional
- [ ] B) Porque o histórico de versões deixaria de refletir com exatidão o que realmente foi executado em cada ambiente (dev, homologação, produção)
- [ ] C) Porque o Postgres bloqueia a escrita em arquivos `.sql` após a primeira leitura
- [ ] D) Porque o Composer trava o projeto quando detecta a alteração

---

### 7. Qual é a forma correta de "atualizar" uma procedure já aplicada, segundo o mecanismo implementado?

- [ ] A) Editar o arquivo `Vxxx` já aplicado e rodar `procedures:migrate` novamente
- [ ] B) Apagar o registro correspondente direto na tabela `schema_procedures`
- [ ] C) Criar um novo arquivo com o próximo número de versão (ex: `V002__...sql`) contendo o `CREATE OR REPLACE FUNCTION` atualizado
- [ ] D) Rodar `php artisan migrate:fresh`

---

### 8. O comando `procedures:migrate` executa o SQL de cada arquivo pendente usando `DB::unprepared(...)` dentro de uma `DB::transaction(...)`. Qual a vantagem disso?

- [ ] A) Deixa o comando mais rápido, pulando a validação de sintaxe SQL
- [ ] B) Garante que, se algo falhar durante a aplicação, a alteração é revertida (não fica um estado parcial no banco)
- [ ] C) Permite rodar o comando sem estar conectado ao banco de dados
- [ ] D) Faz o Laravel gerar automaticamente uma Migration equivalente

---

### 9. Ao rodar `php artisan procedures:migrate` quando **todas** as versões já estão aplicadas e nenhum arquivo mudou, qual o comportamento esperado?

- [ ] A) O comando falha com erro, pois não há nada para aplicar
- [ ] B) O comando informa educadamente que tudo já está em dia, sem aplicar nada de novo
- [ ] C) O comando reaplica todas as versões do zero
- [ ] D) O comando apaga a tabela `schema_procedures`

---

### 10. Qual comando Artisan foi criado para **listar** (sem aplicar nada) o que já está aplicado e o que está pendente neste ambiente?

- [ ] A) `php artisan procedures:list`
- [ ] B) `php artisan migrate:status`
- [ ] C) `php artisan procedures:status`
- [ ] D) `php artisan schema:procedures`

---

### 11. Na classe `ProcedureFile` (`app/Support/Procedures/ProcedureFile.php`), qual é a responsabilidade principal dela?

- [ ] A) Executar as queries HTTP das rotas da API
- [ ] B) Ler os arquivos `.sql` da pasta `database/procedures/`, extrair versão/nome do nome do arquivo e calcular o checksum de cada um
- [ ] C) Validar o formulário de cadastro de funcionários
- [ ] D) Gerenciar as credenciais do `.env`

---

### 12. Por que os comandos `ProceduresMigrate` e `ProceduresStatus`, dentro de `app/Console/Commands/`, não precisam ser registrados manualmente em nenhum lugar para aparecerem no `php artisan list`?

- [ ] A) Porque foram registrados manualmente no `composer.json`
- [ ] B) Porque o Laravel faz auto-discovery de Commands na pasta `app/Console/Commands/`
- [ ] C) Porque todo Controller é automaticamente um Command
- [ ] D) Porque eles foram adicionados na tabela `schema_procedures`

---

### 13. A coluna `applied_by` da tabela `schema_procedures` guarda, por padrão, o usuário do sistema operacional que rodou o comando (via `get_current_user()`), com fallback para qual valor?

- [ ] A) `"root"`
- [ ] B) `"laravel"`
- [ ] C) `"sistema"`
- [ ] D) `null`

---

### 14. Existe uma constraint `unique` na coluna `version` da tabela `schema_procedures`. Qual problema essa constraint ajuda a evitar?

- [ ] A) Duas tabelas com o mesmo nome no banco
- [ ] B) Duas linhas registrando a mesma versão de procedure como aplicada (inconsistência no histórico)
- [ ] C) Dois usuários com o mesmo e-mail no cadastro
- [ ] D) Dois Controllers com o mesmo nome de método

---

### 15. Qual é a diferença de propósito entre `php artisan migrate` e `php artisan procedures:migrate` neste projeto?

- [ ] A) São exatamente a mesma coisa, apenas com nomes diferentes
- [ ] B) `migrate` aplica alterações de **estrutura** (tabelas/colunas) definidas em `database/migrations/`; `procedures:migrate` aplica **lógica de banco** (functions/procedures) definida em `database/procedures/`
- [ ] C) `migrate` só funciona em produção; `procedures:migrate` só funciona em desenvolvimento
- [ ] D) `procedures:migrate` substitui completamente o `migrate` a partir de agora

---

### 16. Antes desta fase, a function `hello_world()` era criada dentro de uma Migration comum (`2026_08_21_030853_create_hello_world_function.php`). O que foi feito com essa migration ao migrar a function para o novo padrão?

- [ ] A) Ela foi mantida exatamente igual, sem nenhuma alteração
- [ ] B) Ela foi removida, já que só continha a criação da function (que passou a viver em `V001__create_proc_hello_world.sql`) e não continha nenhuma estrutura de tabela
- [ ] C) Ela foi renomeada para `V001__create_proc_hello_world.sql`
- [ ] D) Ela foi convertida em um Seeder

---

### 17. Segundo o README atualizado, como `procedures:migrate` deve ser executado em homologação e produção?

- [ ] A) Nunca deve ser executado fora do ambiente local
- [ ] B) Como parte do processo de deploy, do mesmo jeito que se roda `php artisan migrate`
- [ ] C) Apenas manualmente, uma vez por ano
- [ ] D) Só deve rodar se o time de banco de dados autorizar por e-mail a cada versão

---

### 18. O que a rota `/api/hello-db` (`HelloDbController`) faz depois que a function `hello_world()` passou a ser aplicada via `procedures:migrate`?

- [ ] A) Parou de funcionar, pois a function foi removida do banco
- [ ] B) Continua funcionando normalmente, chamando `hello_world()` via `DB::select`, agora com a function versionada formalmente
- [ ] C) Passou a exigir autenticação
- [ ] D) Passou a retornar diretamente o conteúdo do arquivo `.sql`

---

### 19. Esse mecanismo de versionamento (arquivos numerados, tabela de controle, checksum, bloqueio de edição silenciosa) é inspirado em qual tipo de ferramenta amplamente usada no mercado?

- [ ] A) Ferramentas de CI/CD como GitHub Actions
- [ ] B) Ferramentas de migration de banco de dados como o Flyway
- [ ] C) Ferramentas de monitoramento como o Grafana
- [ ] D) Gerenciadores de pacotes como o Composer

---

### 20. De forma geral, qual é o principal ganho de ter esse mecanismo de versionamento de procedures ao evoluir o projeto entre dev, homologação e produção?

- [ ] A) O banco de dados fica mais rápido automaticamente
- [ ] B) Elimina a necessidade de qualquer teste automatizado
- [ ] C) Garante que todos os ambientes apliquem exatamente as mesmas versões de procedures, na mesma ordem, com um histórico auditável de quando e por quem cada uma foi aplicada
- [ ] D) Permite editar procedures direto em produção sem deixar rastro

---

Boa sorte! Confira suas respostas em `gabarito.md`.
