<?php

namespace AppBundle\Repository;

/**
 * DailyTasksRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class DailyTasksRepository extends \Doctrine\ORM\EntityRepository
{
    public function getForDay(\DateTime $date): array
    {
        return $this->getEntityManager()->createQuery("SELECT d
                                   FROM AppBundle:DailyTask d
                                   WHERE   (d.weekday = DAYNAME(:date)
                                           OR d.weekday = 'all'
                                           OR (DAYNAME(:date) IN ('Sunday','Saturday') AND d.weekday = 'day_off' )
                                           OR (DAYNAME(:date) NOT IN ('Sunday','Saturday') AND d.weekday = 'workday' ))
                                           AND d.time IS NOT NULL
                                    ORDER BY d.time")->setParameter('date', $date)->getResult();
    }
    public function getTodoForDay(\DateTime $date): array
    {
        return $this->getEntityManager()->createQuery("SELECT d
                                   FROM AppBundle:DailyTask d
                                   WHERE   (d.weekday = DAYNAME(:date)
                                           OR d.weekday = 'all'
                                           OR (DAYNAME(:date) IN ('Sunday','Saturday') AND d.weekday = 'day_off' )
                                           OR (DAYNAME(:date) NOT IN ('Sunday','Saturday') AND d.weekday = 'workday' ))
                                           AND d.time IS NULL
                                    ORDER BY d.time")->setParameter('date', $date)->getResult();
    }
}
