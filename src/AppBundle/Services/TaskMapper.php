<?php
/**
 * Created by PhpStorm.
 * User: Audi
 * Date: 15.07.2017
 * Time: 10:06
 */

namespace AppBundle\Services;


use AppBundle\Entity\DailyTask;
use AppBundle\Entity\Event;
use AppBundle\Entity\Periodical;
use AppBundle\Entity\Ponder;
use AppBundle\Entity\TaskInterface;
use AppBundle\Entity\Todo;
use AppBundle\Entity\Until;

class TaskMapper
{
    private const MAP = [
        'daily_tasks' => DailyTask::class,
        'events' => Event::class,
        'todo' => Todo::class,
        'periodical' => Periodical::class,
        'until' => Until::class,
        'ponder' => Ponder::class
    ];

    public static function getTargetClassName(string $prefix): string
    {

        if (isset(self::MAP[$prefix])) {
            return self::MAP[$prefix];
        }

        throw new \RuntimeException('Task not found');

    }


    public static function getPrefix($object_or_class): ?string
    {
        if (is_subclass_of($object_or_class, TaskInterface::class) !== true) {
            throw new \InvalidArgumentException('Wrong argument (not an expected object or class)');
        }

        $class = is_object($object_or_class) ? get_class($object_or_class) : $object_or_class;


        return ($result = array_search($class, self::MAP, true)) ? $result : null;
    }
}