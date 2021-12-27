<?php

namespace PyrobyteWeb\CronTaskDatabase\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use PyrobyteWeb\CronTaskDatabase\CronTask;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    public static function scheduler(Schedule $schedule)
    {
        if (self::isRunning()) {
            Log::info('Artisan schedule is still running');
            return;
        }

        set_time_limit(3600 * 24);
        ini_set('max_execution_time', 3600 * 24);

        $tasks = (new CronTask())
            ->where('status', CronTask::STATUS_ACTIVE)
            ->get();

        /** @var CronTask $task */
        foreach ($tasks as $task) {
            $period = trim($task->getRunPeriod());
            $options = [];

            if (!$period) {
                Log::critical('Ошибка постановки Cron задачи ' .
                    $task->getName() . ' (класс ' . $task->getCode() . '): не задан период.');
                continue;
            }

            if (self::isPeriodOptionsNeeded($period)) {
                $options = $task->getPeriodOptions();
                if (!$options) {
                    Log::critical('Ошибка постановки Cron задачи ' .
                        $task->getName() . ' (класс ' . $task->getCode() . '): не заданы опции периода.');
                    continue;
                }
                if (!is_array($options)) {
                    Log::critical('Ошибка постановки Cron задачи ' .
                        $task->getName() . ' (класс ' . $task->getCode() . '): опции периода не являются массивом.');
                    continue;
                }
            }

            $class = substr($task->getCode(), 1);
            $job = $schedule->job($class, 'schedule');

            if (!method_exists($job, $period)) {
                Log::error('Ошибка постановки Cron задачи ' .
                    $task->getName() . ' (класс ' . $task->getCode() . '): неизвестный класс задачи.');
                continue;
            }

            $job->{$period}(...$options);
        }
    }

    /**
     * Проверяет, запущен ли крон сейчас. Сейчас делает это только для линукс. Под другими оськами считаем, что крон не запущен
     * @return bool
     */
    public static function isRunning()
    {
        if (!self::isLinux()) {
            return false;
        }

        $command = 'ps aux | grep php';
        $output = shell_exec($command) . '';

        // Подсчитываем кол-во запущенных процессов. Больше 2 не запускаем. В linux по крон запускаем пишет 2 стркои процесса
        return substr_count($output, 'schedule:run') > 2;
    }

    /**
     * Проверяет, линкус ли это
     *
     * @return bool
     */
    public static function isLinux()
    {
        return Str::contains(mb_strtolower(PHP_OS), 'linux');
    }

    /**
     * Проверяет, требуются ли опции для периода запуска крон-задачи
     * @param string $period
     * @return bool
     */
    private static function isPeriodOptionsNeeded(string $period)
    {
        $periodsWithOptions = [
            'cron',
            'hourlyAt',
            'dailyAt',
            'twiceDaily',
            'weeklyOn',
            'monthlyOn',
            'timezone',
        ];

        if (in_array($period, $periodsWithOptions)) {
            return true;
        }
        return false;
    }
}
