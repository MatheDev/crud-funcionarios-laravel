# Gabarito — Prova 2 (Intermediário — Versionamento de Procedures)

| Questão | Resposta | Explicação |
|---|---|---|
| 1 | B | O objetivo é separar a criação de **estrutura** (migrations do Laravel) da criação de **lógica de banco** (functions/procedures), com um fluxo de versionamento próprio, auditável e replicável entre ambientes. |
| 2 | C | `schema_procedures` é a tabela de controle: registra nome, versão, checksum, data e usuário de cada versão de procedure já aplicada neste ambiente. |
| 3 | B | O número de 3 dígitos é a versão sequencial do arquivo, usada tanto para ordenar a aplicação quanto como identificador único (é o que garante que `V001` só existe uma vez). |
| 4 | B | O checksum é um hash (sha256) do conteúdo do arquivo `.sql`, guardado junto do registro de aplicação. Ele é comparado a cada execução para detectar alterações no arquivo depois de já aplicado. |
| 5 | C | O `procedures:migrate` recalcula o checksum do arquivo e compara com o que está salvo em `schema_procedures`. Se divergir, ele **recusa aplicar**, mostra um erro claro e orienta a criar uma nova versão (`V002`) em vez de editar a existente. |
| 6 | B | Se edições silenciosas fossem permitidas, o histórico de `schema_procedures` não refletiria mais com exatidão o que foi de fato executado em cada ambiente — quebrando a garantia central de um mecanismo de versionamento. |
| 7 | C | A forma correta é sempre criar um novo arquivo com o próximo número de versão, contendo o SQL atualizado (ex: `CREATE OR REPLACE FUNCTION`). Editar um arquivo já aplicado é bloqueado pelo comando. |
| 8 | B | A transaction garante atomicidade: se a execução do SQL ou o registro em `schema_procedures` falhar no meio do caminho, tudo é revertido — não fica um estado parcial (function criada mas sem registro, ou vice-versa). |
| 9 | B | Quando não há nada pendente e nenhum checksum diverge, o comando apenas informa educadamente que tudo já está em dia, sem tentar reaplicar nada. |
| 10 | C | `php artisan procedures:status` foi o comando de leitura criado para listar, em formato de tabela, o que está aplicado e o que está pendente — sem alterar nada no banco. |
| 11 | B | `ProcedureFile` é a classe responsável por ler os arquivos `.sql` de `database/procedures/`, extrair versão e nome a partir do padrão do nome do arquivo, e calcular o checksum de cada um — usada tanto por `procedures:migrate` quanto por `procedures:status`. |
| 12 | B | A partir do Laravel 11/13, qualquer classe de Command colocada em `app/Console/Commands/` é descoberta automaticamente pelo framework, sem necessidade de registro manual (diferente de versões antigas que exigiam listar em `Kernel.php`). |
| 13 | C | O valor padrão de `applied_by`, quando não é possível obter o usuário do sistema operacional, é a string `"sistema"`. |
| 14 | B | A constraint `unique` em `version` impede que duas linhas registrem a mesma versão como aplicada, o que manteria o histórico consistente (uma versão = uma aplicação registrada). |
| 15 | B | `migrate` cuida de **estrutura** (tabelas, colunas, índices) definida em `database/migrations/`; `procedures:migrate` cuida de **lógica de banco** (functions/procedures) definida em `database/procedures/`. São dois mecanismos complementares, não concorrentes. |
| 16 | B | A migration antiga só continha a criação da function `hello_world()` — nenhuma estrutura de tabela. Como essa lógica passou a viver em `V001__create_proc_hello_world.sql`, a migration foi removida, mantendo migrations dedicadas apenas a estrutura. |
| 17 | B | Segundo o README, `procedures:migrate` deve rodar como parte do processo de deploy em homologação/produção, do mesmo jeito que `php artisan migrate` — garantindo que todo ambiente aplique as mesmas versões. |
| 18 | B | A rota continua funcionando normalmente: `HelloDbController` chama `hello_world()` via `DB::select`, só que agora essa function é criada e rastreada formalmente pelo mecanismo de versionamento, em vez de por uma migration solta. |
| 19 | B | O mecanismo é inspirado em ferramentas de migration de banco de dados como o **Flyway** (arquivos numerados, tabela de histórico, checksum, bloqueio de alteração retroativa). |
| 20 | C | O principal ganho é garantir consistência entre ambientes: todos aplicam exatamente as mesmas versões, na mesma ordem, com um histórico auditável (quem aplicou, quando, e se algo foi alterado indevidamente). |

---

## Pontuação

- 18 a 20 acertos: excelente domínio do mecanismo de versionamento de procedures e de como ele se encaixa no fluxo Laravel.
- 14 a 17 acertos: bom entendimento, revise os pontos errados antes de seguir para a próxima fase.
- Abaixo de 14: vale reler a seção "Versionamento de Stored Procedures / Functions" do `README.md` e reexecutar `procedures:migrate` / `procedures:status` no projeto, observando o comportamento na prática (inclusive o bloqueio ao editar um arquivo já aplicado).
