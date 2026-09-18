<?php

namespace App\Support\Procedures;

use Illuminate\Support\Facades\File;
use RuntimeException;

class ProcedureFile
{
    public function __construct(
        public readonly int $version,
        public readonly string $name,
        public readonly string $filename,
        public readonly string $contents,
        public readonly string $checksum,
    ) {
    }

    /**
     * @return array<int, self>
     */
    public static function allFromDirectory(): array
    {
        $directory = database_path('procedures');

        if (! File::isDirectory($directory)) {
            return [];
        }

        $files = [];

        foreach (File::files($directory) as $file) {
            if ($file->getExtension() !== 'sql') {
                continue;
            }

            $files[] = self::fromPath($file->getPathname());
        }

        usort($files, fn (self $a, self $b) => $a->version <=> $b->version);

        return $files;
    }

    private static function fromPath(string $path): self
    {
        $filename = basename($path);

        if (! preg_match('/^V(\d{3})__(.+)\.sql$/', $filename, $matches)) {
            throw new RuntimeException(sprintf(
                'Arquivo de procedure com nome inválido: "%s". Use o padrão V{3 dígitos}__{acao}_{descricao}.sql.',
                $filename,
            ));
        }

        $contents = File::get($path);

        return new self(
            version: (int) $matches[1],
            name: $matches[2],
            filename: $filename,
            contents: $contents,
            checksum: hash('sha256', $contents),
        );
    }
}
