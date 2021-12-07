<?php

namespace PyrobyteWeb\CronTasksDatabase;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CronTask
 * @property $id
 * @property $name
 * @property $code
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

    /**
     * Получает опции периода для крон-задачи
     * @return array|null
     */
    public function getPeriodOptions():? array
    {
        $code = $this->getCode();
        $options = [];

        switch ($code) {
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
    public function getCode()
    {
        return $this->code;
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
