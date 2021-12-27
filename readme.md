# Cron Tasks Database Laravel
Laravel 8+  
PHP 7.4+  

1. В файле app.php, в секцию packages добавить:
   \PyrobyteWeb\CronTasksDatabase\CronTasksDatabaseServiceProvider::class
2. ``php artisan vendor:publish --provider="PyrobyteWeb\CronTaskDatabase\CronTaskDatabaseServiceProvider"``
3. Вызвать ``PyrobyteWeb\CronTaskDatabase\Kernel::scheduler($schedule)`` в ``App\Console\Kernel``
4. Запустить ``php artisan cron-task:add {name}`` для создания миграция на добавление новой крон таски  
