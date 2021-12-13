<?php

namespace PyrobyteWeb\CronTaskDatabase\Console;

use Illuminate\Database\Console\Migrations\BaseCommand;
use Illuminate\Database\Console\Migrations\TableGuesser;
use PyrobyteWeb\CronTaskDatabase\Database\Migrations\CronTaskCreator;
use Illuminate\Support\Composer;
use Illuminate\Support\Str;

class CronTaskAddCommand extends BaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron-task:add {name : name task} {--fullpath : Output the full path of the migration}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * The migration creator instance.
     *
     * @var CronTaskCreator
     */
    protected $creator;

    /**
     * The Composer instance.
     *
     * @var Composer
     */
    protected $composer;

    /**
     * Create a new migration install command instance.
     *
     * @param CronTaskCreator $creator
     * @param Composer $composer
     * @return void
     */
    public function __construct(CronTaskCreator $creator, Composer $composer)
    {
        parent::__construct();

        $this->creator = $creator;
        $this->composer = $composer;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = Str::snake(trim('add_cron_task_').$this->input->getArgument('name'));
        [$table, $create] = TableGuesser::guess($name);

        $this->writeMigration($name, $table, $create);

        $this->composer->dumpAutoloads();
    }

    protected function writeMigration($name, $table, $create)
    {
        $file = $this->creator->create(
            $name, $this->getMigrationPath(), $table, $create
        );

        if (! $this->option('fullpath')) {
            $file = pathinfo($file, PATHINFO_FILENAME);
        }

        $this->line("<info>Created Migration:</info> {$file}");
    }
}
