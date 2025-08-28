<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeRepository extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a repository and its interface';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        $var_name = strtolower($name);
        
        $repository = File::get(base_path('app/Stubs/Repository.stub'));
        $interface = File::get(base_path('app/Stubs/Interface.stub'));
        
        $repositoryContent = str_replace(
            ['{{name}}'],
            [$name],
            $repository
        );
        
        $interfaceContent = str_replace(
            ['{{name}}', '{{var_name}}'],
            [$name, $var_name],
            $interface
        );
        
        $repositoryPath = app_path("Repositories/{$name}Repository.php");
        File::put($repositoryPath, $repositoryContent);
        
        $interfacePath = app_path("Interfaces/{$name}Interface.php");
        File::put($interfacePath, $interfaceContent);
        
        $this->info("{$name} repository and its interface created successfully.");
    }
}
