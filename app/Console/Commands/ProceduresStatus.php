<?php

namespace App\Console\Commands;

use App\Support\Procedures\ProcedureFile;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ProceduresStatus extends Command
{
    protected $signature = 'procedures:status';

    protected $description = 'Lista o status (aplicado/pendente) dos arquivos de database/procedures/ neste ambiente';

    public function handle(): int
    {
        $files = ProcedureFile::allFromDirectory();

        if ($files === []) {
            $this->components->info('Nenhum arquivo de procedure encontrado em database/procedures/.');

            return self::SUCCESS;
        }

        $applied = DB::table('schema_procedures')
            ->get()
            ->keyBy('version');

        $rows = [];

        foreach ($files as $file) {
            $record = $applied->get($file->version);

            if ($record === null) {
                $rows[] = [
                    sprintf('V%03d', $file->version),
                    $file->name,
                    'pendente',
                    '-',
                    '-',
                ];

                continue;
            }

            $status = $record->checksum === $file->checksum
                ? 'aplicado'
                : 'aplicado (checksum divergente!)';

            $rows[] = [
                sprintf('V%03d', $file->version),
                $file->name,
                $status,
                $record->applied_at,
                $record->applied_by,
            ];
        }

        $this->table(
            ['Versão', 'Nome', 'Status', 'Aplicado em', 'Aplicado por'],
            $rows,
        );

        $pendingCount = collect($files)->filter(fn (ProcedureFile $f) => ! $applied->has($f->version))->count();

        if ($pendingCount > 0) {
            $this->components->warn(sprintf('%d versão(ões) pendente(s). Rode "php artisan procedures:migrate" para aplicar.', $pendingCount));
        } else {
            $this->components->info('Tudo em dia: todas as procedures já estão aplicadas neste ambiente.');
        }

        return self::SUCCESS;
    }
}
