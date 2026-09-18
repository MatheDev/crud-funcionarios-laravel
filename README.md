<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

In addition, [Laracasts](https://laracasts.com) contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

You can also watch bite-sized lessons with real-world projects on [Laravel Learn](https://laravel.com/learn), where you will be guided through building a Laravel application from scratch while learning PHP fundamentals.

## Agentic Development

Laravel's predictable structure and conventions make it ideal for AI coding agents like Claude Code, Cursor, and GitHub Copilot. Install [Laravel Boost](https://laravel.com/docs/ai) to supercharge your AI workflow:

```bash
composer require laravel/boost --dev

php artisan boost:install
```

Boost provides your agent 15+ tools and skills that help agents build Laravel applications while following best practices.

## Versionamento de Stored Procedures / Functions

O projeto usa um mecanismo próprio, inspirado no Flyway, para versionar
stored procedures e functions do PostgreSQL de forma independente das
migrations do Laravel (que cuidam apenas de estrutura de tabelas).

- Os arquivos ficam em `database/procedures/`, seguindo o padrão de nome
  `V{numero com 3 dígitos}__{acao}_{descricao}.sql`, por exemplo
  `V001__create_proc_hello_world.sql`.
- Cada arquivo aplicado fica registrado na tabela `schema_procedures`
  (nome, versão, checksum do conteúdo, data e usuário de aplicação).
- **Um arquivo já aplicado nunca deve ser editado.** Se o conteúdo de uma
  versão já aplicada mudar, `procedures:migrate` detecta a divergência de
  checksum, recusa aplicar e orienta a criar uma nova versão.

### Como criar uma nova versão

1. Crie um novo arquivo em `database/procedures/`, com o próximo número de
   versão, por exemplo `V002__alter_proc_hello_world.sql`.
2. Escreva o SQL (CREATE OR REPLACE FUNCTION, CREATE PROCEDURE, etc.).
3. Aplique localmente:

   ```bash
   sail artisan procedures:migrate
   ```

4. Confira o que está aplicado/pendente:

   ```bash
   sail artisan procedures:status
   ```

### Homologação / Produção

Nesses ambientes, `php artisan procedures:migrate` deve ser executado como
parte do processo de deploy, do mesmo jeito que se roda `php artisan
migrate`. Como o comando é idempotente (só aplica o que ainda não foi
aplicado, e recusa alterações silenciosas em versões antigas), é seguro
rodá-lo a cada deploy.

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
