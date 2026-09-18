<?php

namespace App\Console\Commands;

use App\Support\Procedures\ProcedureFile;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ProceduresMigrate extends Command
{
    protected $signature = 'procedures:migrate';

    protected $description = 'Aplica os arquivos .sql pendentes de database/procedures/ no banco de dados';

    public function handle(): int
    {
        $files = ProcedureFile::allFromDirectory();

        if ($files === []) {
            $this->components->info('Nenhum arquivo de procedure encontrado em database/procedures/.');

            return self::SUCCESS;
        }

        $applied = DB::table('schema_procedures')->pluck('checksum', 'version');

        $pending = [];

        foreach ($files as $file) {
            $existingChecksum = $applied->get($file->version);

            if ($existingChecksum === null) {
                $pending[] = $file;

                continue;
            }

            if ($existingChecksum !== $file->checksum) {
                $this->components->error(sprintf(
                    'A versão V%03d (%s) já foi aplicada anteriormente, mas o conteúdo do arquivo foi alterado.',
                    $file->version,
                    $file->name,
                ));

                $this->newLine();
                $this->line('  Editar um arquivo de procedure já aplicado não é permitido: o histórico de');
                $this->line('  versões deixaria de refletir o que realmente foi executado em cada ambiente.');
                $this->newLine();
                $this->line(sprintf(
                    '  Em vez disso, crie um novo arquivo V%03d__{acao}_{descricao}.sql em database/procedures/',
                    $file->version + 1,
                ));
                $this->line('  com o conteúdo atualizado.');
                $this->newLine();

                return self::FAILURE;
            }
        }

        if ($pending === []) {
            $this->components->info('Tudo em dia: todas as procedures já estão aplicadas neste ambiente.');

            return self::SUCCESS;
        }

        foreach ($pending as $file) {
            $this->components->task(
                sprintf('Aplicando V%03d__%s', $file->version, $file->name),
                function () use ($file) {
                    DB::transaction(function () use ($file) {
                        DB::unprepared($file->contents);

                        DB::table('schema_procedures')->insert([
                            'name' => $file->name,
                            'version' => $file->version,
                            'checksum' => $file->checksum,
                            'applied_at' => now(),
                            'applied_by' => get_current_user() ?: 'sistema',
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    });
                }
            );
        }

        $this->newLine();
        $this->components->info(sprintf('%d procedure(s) aplicada(s) com sucesso.', count($pending)));

        return self::SUCCESS;
    }
}
