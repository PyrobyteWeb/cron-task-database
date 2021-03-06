<?php

namespace PyrobyteWeb\CronTaskDatabase;

use PyrobyteWeb\CronTaskDatabase\Database\Migrations\CronTaskCreator;
use Illuminate\Support\ServiceProvider;
use PyrobyteWeb\CronTaskDatabase\Console\CronTaskAddCommand;

class CronTaskDatabaseServiceProvider extends ServiceProvider
{
    protected array $commands = [
        'CronTaskAdd' => 'command.cron-task.add',
    ];

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton('migration.cron-task.creator', function ($app) {
            return new CronTaskCreator($app['files'], $app->basePath('stubs'));
        });

        $this->publishes([
            __DIR__ . '/../database/migrations' => database_path('migrations'),
        ], 'crontasks-migrations');

        $this->registerCronTaskAddCommand();
        $this->registerCommands($this->commands);
    }

    protected function registerCronTaskAddCommand()
    {
        $this->app->singleton('command.cron-task.add', function ($app) {
            $creator = $app['migration.cron-task.creator'];

            $composer = $app['composer'];

            return new CronTaskAddCommand($creator, $composer);
        });
    }

    protected function registerCommands(array $commands)
    {
        foreach (array_keys($commands) as $command) {
            $this->{"register{$command}Command"}();
        }

        $this->commands(array_values($commands));
    }
}
