# Correção e Avaliação — Prova 1 (Iniciante em Laravel)

## Nota final: 17 / 20 (85%)

Pela régua do próprio gabarito, isso te coloca na faixa **"bom entendimento, revise os pontos
errados"** (14 a 17 acertos) — bem na borda de subir para a faixa "excelente" (18 a 20).

## Números gerais

- **Acertos:** 17
- **Erros:** 3 → questões **6, 12 e 16**
- **Respostas marcadas como `chute`:** 6 → questões **5, 6, 8, 9, 11 e 15**
  - Dessas, você acertou **5** (5, 8, 9, 11, 15) e errou **1** (6)

## Sobre os chutes

Acertar 5 de 6 chutes é um sinal positivo: mesmo sem confiança na resposta, sua eliminação de
alternativas absurdas ("chute educado") está funcionando. Mas isso não é o mesmo que saber o
conteúdo — vale revisar de verdade os temas por trás desses chutes, mesmo os que você acertou:

- **Q5** — comando `php artisan key:generate` para gerar a `APP_KEY`.
- **Q6** — o que é o `artisan` (você errou este: achou que era "o arquivo principal de rotas";
  na verdade é a CLI do Laravel usada para migrations, geração de arquivos, cache, etc.).
- **Q8** — diferença entre `web.php` (rotas com sessão/cookies, navegador) e `api.php` (rotas
  stateless, para clientes/API).
- **Q9** — single action controller (`__invoke`) quando o Controller resolve só uma rota.
- **Q11** — facade `DB` para executar SQL direto na conexão configurada.
- **Q15** — prefixo de data/hora no nome da migration define a ordem de execução.

## Erros que não foram chute (aqui está o gap real)

- **Q12** — Você respondeu que a function `hello_world()` do PostgreSQL é criada "em um
  Controller". Na verdade ela é criada numa **Migration**, via `DB::unprepared(...)`. Isso indica
  uma confusão entre **usar** algo do banco (o `HelloDbController` chama a function com
  `DB::select`) e **criar** esse algo (isso acontece na migration, não no controller). Vale
  reler a migration `2026_08_21_030853_create_hello_world_function.php` do próprio projeto lado a
  lado com o `HelloDbController`.
- **Q16** — Você confundiu **Laravel Sail** com **Eloquent/ORM**. Sail é a CLI leve para
  gerenciar o ambiente Docker do projeto (subir containers, rodar `sail artisan`, etc.); ORM é
  papel do Eloquent (que você acertou corretamente na Q18). Vale fixar a diferença entre essas
  duas peças, já que são conceitos bem distintos que você já domina separadamente mas trocou na
  hora de aplicar.

## Visão geral de como você foi

O fluxo central de uma aplicação Laravel — rota → controller → resposta JSON, MVC, `.env`,
Composer, Eloquent como ORM — está sólido: praticamente nada errado aí. As dificuldades
concentram-se na camada de **ferramentas e infraestrutura** do projeto (Artisan como CLI, Sail
como gerenciador de Docker, e onde exatamente vive uma function SQL criada via migration). Isso é
esperado para quem está começando: é a parte mais "ferramental" e menos intuitiva do ecossistema
Laravel, comparada à parte de rotas/controllers que é mais parecida com o que já se vê em outras
linguagens web.

## O que falta estudar (prioridade)

1. **Migrations com SQL puro** (`DB::unprepared`) — reler a migration da function `hello_world()`
   e entender que ela roda uma vez (na hora do `migrate`) para criar algo permanente no banco,
   diferente do controller que roda a cada requisição.
2. **Papel do Artisan** — é a CLI (`php artisan <comando>`), não um arquivo de rotas. Vale rodar
   `php artisan list` no projeto para ver a variedade de comandos disponíveis.
3. **Sail vs Eloquent** — Sail = ambiente/Docker; Eloquent = ORM. São camadas diferentes do
   projeto (infraestrutura vs. acesso a dados).
4. Revisar sem pressa os temas dos chutes acertados (Q5, 8, 9, 11, 15) para transformar "acertei
   sem saber" em conhecimento sólido antes da próxima prova.
