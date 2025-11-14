<?php

namespace Alphavel\Cache;

use Alphavel\Core\ServiceProvider;

class CacheServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton('cache', function () {
            $config = $this->app->config('cache', []);
            $size = $config['size'] ?? 1024;
            $valueSize = $config['value_size'] ?? 4096;

            return Cache::getInstance($size, $valueSize);
        });

        // Auto-register facade
        $this->facades([
            'Cache' => 'cache',
        ]);
    }

    public function boot(): void
    {
        //
    }
}
