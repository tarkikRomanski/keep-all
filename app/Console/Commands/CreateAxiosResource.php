<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateAxiosResource extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */

    protected $signature = 'make:axios:resource {name} {--route=}';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates api resource based on axios';
    /**
     * Create a new command instance.
     *
     * @return void
     */

    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Execute the console command.
     *
     * @return bool
     */

    public function handle()
    {
        $name = $this->argument('name');
        $route = $this->option('route');
        $resourceClassName = ucfirst($name) . 'Resource';
        $resourceRouteName = $route ?? strtolower($name);
        $resourceFileName = $resourceClassName . '.js';
        if(!file_exists(base_path('resources/assets/js/resources/Resource.js'))) {
            $this->createResourceParent();
        }
        if(file_exists(base_path('resources/assets/js/resources/' . $resourceFileName))) {
            echo 'Resource is exist', "\n";
            return false;
        }
        $this->createResource($resourceClassName, $resourceRouteName, $resourceFileName);
        return true;
    }

    /**
     * Create parent class for axios resources
     */
    private function createResourceParent()
    {
        $resourceParentTemplate = file_get_contents(__DIR__ . '/templates/ResourceParent');
        mkdir(base_path('resources/assets/js/resources'));
        file_put_contents(base_path('resources/assets/js/resources/Resource.js'), $resourceParentTemplate);
    }

    /**
     * Create resource class
     * @param $resourceClassName
     * @param $resourceRouteName
     * @param $resourceFileName
     */
    private function createResource($resourceClassName, $resourceRouteName, $resourceFileName)
    {
        $resourceTemplate = file_get_contents(__DIR__ . '/templates/ResourceTemplate');
        $resourceTemplate = str_replace('{{ResourceClassName}}', $resourceClassName, $resourceTemplate);
        $resourceTemplate = str_replace('{{ResourceRoute}}', $resourceRouteName, $resourceTemplate);
        file_put_contents(base_path('resources/assets/js/resources/' . $resourceFileName), $resourceTemplate);
    }
}