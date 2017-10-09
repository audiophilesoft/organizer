<?php
declare(strict_types=1);

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Periodical
 *
 * @ORM\Table(name="periodical")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PeriodicalRepository")
 */
class Periodical extends TaskAbstract
{
    use HasLastDoneFieldTrait;

    /**
     * @var int
     * @Assert\GreaterThan(0)
     * @ORM\Column(name="period", type="smallint", options={"unsigned":true})
     */
    private $period = 7;

    /**
     * @return int
     */
    public function getPeriod(): int
    {
        return $this->period;
    }


    /**
     * @param int $period
     */
    public function setPeriod(int $period)
    {
        $this->period = $period;
    }

    public function checkDone(?\DateTime $date = null): bool
    {
        $passed = (int)($date ?? new \DateTime)->diff($this->getLastDone())->format('%a');
        return $passed < $this->getPeriod();
    }

    public function markAsDone(?\DateTime $date = null): void
    {
        $this->setLastDone($date ?? new \DateTime);
    }

    public function markUndone(?\DateTime $date = null): void
    {
        $this->setLastDone(($date ?? new \DateTime)->sub(new \DateInterval("P{$this->getPeriod()}D")));
    }

}
