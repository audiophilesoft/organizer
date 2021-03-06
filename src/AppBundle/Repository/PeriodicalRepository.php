<?php

namespace AppBundle\Repository;

/**
 * PeriodicalRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PeriodicalRepository extends \Doctrine\ORM\EntityRepository
{
    public function getForDay(\DateTime $date): array
    {
        return $this->getEntityManager()->createQuery('SELECT p
                                   FROM AppBundle:Periodical p
                                   WHERE DATE_DIFF(:date, p.last_done) >= p.period
                                   OR p.last_done = :date
                                   ')
            ->setParameter('date', $date)->getResult();
    }
}
