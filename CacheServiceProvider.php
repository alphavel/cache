<?php

namespace Alphavel\Cache;

use Alphavel\Framework\ServiceProvider;

class CacheServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Merge package config with application config
        $this->mergeConfigFrom(
            __DIR__ . '/config/cache.php',
            'cache'
        );

        $this->app->singleton('cache', function ($app) {
            $config = $app->config('cache.stores.swoole_table', []);
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
        // Publish configuration file
        $basePath = dirname(__DIR__, 3);
        
        $this->publishes([
            __DIR__ . '/config/cache.php' => $basePath . '/config/cache.php',
        ], 'config');
    }

    protected function mergeConfigFrom(string $path, string $key): void
    {
        if (!file_exists($path)) {
            return;
        }

        $packageConfig = require $path;
        $appConfig = $this->app->config($key, []);
        $merged = array_replace_recursive($packageConfig, $appConfig);

        $tempFile = sys_get_temp_dir() . '/alphavel_cache_config_' . uniqid() . '.php';
        file_put_contents($tempFile, '<?php return ' . var_export([$key => $merged], true) . ';');
        
        $this->app->loadConfig($tempFile);
        unlink($tempFile);
    }

    protected function publishes(array $paths, string $group = null): void
    {
        foreach ($paths as $source => $destination) {
            $configDir = dirname($destination);
            if (!is_dir($configDir) && strpos($configDir, '/config') !== false) {
                @mkdir($configDir, 0755, true);
            }
        }
    }
}
