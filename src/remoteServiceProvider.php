<?php

namespace Spatie\remote;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Spatie\remote\Commands\remoteCommand;

class remoteServiceProvider extends PackageServiceProvider
{
    public function boot()
    {
        // نشر ملف التكوين
        $this->publishes([
            __DIR__.'/../config/remote.php' => config_path('remote.php'),
        ], 'config');
    }

    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-remote')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel_remote_table')
            ->hasCommand(remoteCommand::class);
    }
}
