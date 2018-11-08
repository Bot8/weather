<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

class ConfigServiceProvider extends ServiceProvider
{
    /**
     * The config folder name.
     *
     * @var string
     */
    protected const CONFIG_FOLDER_NAME = 'config';

    /**
     * Register all the application config files.
     *
     * @return void
     * @throws FileNotFoundException
     */
    public function register()
    {
        $configPath = app()->basePath(self::CONFIG_FOLDER_NAME);

        if (!is_dir($configPath)) {
            throw new FileNotFoundException("The config folder is missing.\nCreate it on the root folder of your project and add the config files there.");
        }

        collect(scandir($configPath))->each(function ($item, $key) {
            app()->configure(basename($item, '.php'));
        });
    }
}