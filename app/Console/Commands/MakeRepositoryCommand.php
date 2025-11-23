<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeRepositoryCommand extends Command
{
    protected $signature = 'make:repository {name}';
    protected $description = 'Create a repository class';

    public function handle()
    {
        $name = $this->argument('name');
        $path = app_path("Repositories/{$name}.php");

        if (File::exists($path)) {
            $this->error("Repositories {$name} already exists!");
            return false;
        }

        // Make directory if needed
        File::ensureDirectoryExists(app_path('Repositories'));

        // Stub template
        $stub = "<?php

namespace App\Repositories;

class {$name}
{
    //
}";

        // Write file
        File::put($path, $stub);

        $this->info("Repository {$name} created successfully.");
        return true;
    }
}
