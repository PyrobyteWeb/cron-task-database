<?php

namespace PyrobyteWeb\CronTaskDatabase;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CronTask
 * @property $id
 * @property $name
 * @property $namespace
 * @property $status
 * @property $sort
 * @property $run_period
 * @property $created_at
 * @property $updated_at
 * @property $description
 * @package App\Models
 */
class CronTask extends Model
{
    use HasFactory;

    const STATUS_ACTIVE = 1;
    const STATUS_DISABLED = 0;

    const INTERVAL_EVERY_MINUTE = 'everyMinute';
    const INTERVAL_EVERY_TWO_MINUTES = 'everyTwoMinutes';
    const INTERVAL_EVERY_THREE_MINUTES = 'everyThreeMinutes';
    const INTERVAL_EVERY_FOUR_MINUTES = 'everyFourMinutes';
    const INTERVAL_EVERY_FIVE_MINUTES = 'everyFiveMinutes';
    const INTERVAL_EVERY_TEN_MINUTES = 'everyTenMinutes';
    const INTERVAL_EVERY_FIFTEEN_MINUTES = 'everyFifteenMinutes';
    const INTERVAL_EVERY_THIRTY_MINUTES = 'everyThirtyMinutes';
    const INTERVAL_HOURLY = 'hourly';
    const INTERVAL_HOURLY_AT = 'hourlyAt';
    const INTERVAL_EVERY_TWO_HOURS = 'everyTwoHours';
    const INTERVAL_EVERY_THREE_HOURS = 'everyThreeHours';
    const INTERVAL_EVERY_FOUR_HOURS = 'everyFourHours';
    const INTERVAL_EVERY_SIX_HOURS = 'everySixHours';
    const INTERVAL_DAILY = 'daily';
    const INTERVAL_WEEKLY = 'weekly';
    const INTERVAL_MONTHLY = 'monthly';
    const INTERVAL_QUARTERLY = 'quarterly';
    const INTERVAL_YEARLY = 'yearly';

    /**
     * Получает опции периода для крон-задачи
     * @return array|null
     */
    public function getPeriodOptions():? array
    {
        $namespace = $this->getNamespace();

        switch ($namespace) {
            default:
                $options = [];
        }

        return $options;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return mixed
     */
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * @return mixed
     */
    public function getRunPeriod()
    {
        return $this->run_period;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }
}
