<?php

namespace App\Model\Enum;

use App\Model\Task;

/**
 * Class TaskStatus
 */
class TaskStatus
{
    /** @const int */
    const Active = 1;
    /** @const int */
    const Completed = 2;

    /** @var int|null */
    private $status;

    /**
     * TaskStatus constructor.
     *
     * @param Task|null $task
     */
    public function __construct(int $status = null)
    {
        $this->status = $status ?: self::Active;
    }

    /**
     * @return string[]
     */
    public static function getStatuses()
    {
        return [
            self::Active    => 'Active',
            self::Completed => 'Completed',
        ];
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $statuses = self::getStatuses();

        return $statuses[$this->status] ?? 'Active';
    }
}
