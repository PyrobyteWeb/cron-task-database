# Cron Tasks Database Laravel
Laravel 8+  
PHP 7.4+  

1. В файле app.php, в секцию packages добавить:
   \PyrobyteWeb\CronTasksDatabase\CronTasksDatabaseServiceProvider::class  
2. Наследовать App\Console\Kernel от PyrobyteWeb\CronTasksDatabase\Console\Kernel  
3. Запустить ``php artisan cron-task:add {name}`` для создания миграция на добавление новой крон таски  
4. ``php artisan vendor:publish --provider="PyrobyteWeb\CronTasksDatabase\CronTasksDatabaseServiceProvider"``  
