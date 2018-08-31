<?php
namespace App\Providers;

use App\Repositories\GistRepository;
use Illuminate\Support\ServiceProvider;
use GuzzleHttp\Client;

class GistRepositoryServiceProvider extends ServiceProvider {
    public function register() 
    {
        $this->app->singleton('App\Repositories\GistRepository', function () {
            return new GistRepository(new Client(['base_uri' => 'https://api.github.com/']));
        });
    }
}