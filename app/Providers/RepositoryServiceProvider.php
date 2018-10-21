<?php
namespace App\Providers;

use App\Repositories\TodoRepository;
use App\Repositories\RepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bind the interface to TodoRepository
     */
    public function register()
    {
        $this->app->bind(
            RepositoryInterface::class,
            TodoRepository::class
        );
    }
}
