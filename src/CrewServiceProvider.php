<?php

namespace Crew;

use Crew\Commands\SyncCommand;
use Illuminate\Console\Events\CommandFinished;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;

class CrewServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/crew.php', 'crew');

        $this->publishes([
            __DIR__.'/../config/crew.php' => config_path('crew.php'),
        ], 'crew-config');

        if ($this->app->runningInConsole()) {
            $this->commands([SyncCommand::class]);

            if (config('crew.auto_sync')) {
                $this->registerBoostHook();
                $this->syncOnFirstInstall();
            }
        }
    }

    private function registerBoostHook(): void
    {
        Event::listen(CommandFinished::class, function (CommandFinished $event) {
            if (in_array($event->command, ['boost:install', 'boost:update'])) {
                Artisan::call('crew:sync', ['--force' => true, '--quiet' => true]);
            }
        });
    }

    private function syncOnFirstInstall(): void
    {
        if (! File::exists(base_path('.claude/agents'))) {
            Artisan::call('crew:sync', ['--quiet' => true]);
        }
    }
}
