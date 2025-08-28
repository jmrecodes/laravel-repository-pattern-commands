<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeService extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a service';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        $var_name = strtolower($name);
        
        $service = File::get(base_path('app/Stubs/Service.stub'));
        
        $serviceContent = str_replace(
            ['{{name}}', '{{var_name}}'],
            [$name, $var_name],
            $service
        );
        
        $servicePath = app_path("Services/{$name}Service.php");
        File::put($servicePath, $serviceContent);
        
        $this->info("{$name} service created successfully.");
    }
}
