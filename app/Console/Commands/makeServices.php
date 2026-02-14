<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class makeServices extends Command
{
    // Signature: php artisan make:module Name
    protected $signature = 'make:module {name : Nama modul, contoh: Employee}';

    protected $description = 'Bikin Service dan FormRequest sekaligus biar gak ribet';

    public function handle()
    {
        $name = Str::studly($this->argument('name'));

        $this->info("🚀 Memulai pembuatan modul untuk: {$name}...");

        // 1. Bikin FormRequest pake bawaan Laravel
        $this->call('make:request', [
            'name' => "{$name}Request"
        ]);

        // 2. Bikin Service secara manual (karena Laravel gak punya generatornya)
        $this->createService($name);

        $this->newLine();
        $this->info("✅ Modul {$name} siap tempur! Alergi technical debt berkurang +1.");
    }

    protected function createService($name)
    {
        $directory = app_path('Services');
        $path = "{$directory}/{$name}Service.php";

        // Cek folder Services, kalau gak ada ya buat (mkdir -p)
        if (!File::isDirectory($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        if (File::exists($path)) {
            $this->error("🚨 Service {$name}Service sudah ada, skip!");
            return;
        }

        $template = $this->getServiceTemplate($name);

        File::put($path, $template);
        $this->line("<fg=green>CREATED</> Service: app/Services/{$name}Service.php");
    }

    protected function getServiceTemplate($name)
    {
        return <<<PHP
<?php

namespace App\Services;

/**
 * Class {$name}Service
 * Handle business logic buat {$name}
 */
class {$name}Service
{
    public function getDashboardData(array \$filters = [])
    {
        // Pake query scope atau logic sakral lu di sini
        return [];
    }
}
PHP;
    }
}