<?php
declare(strict_types=1);

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * DailyTask
 *
 * @ORM\Table(name="daily")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DailyTasksRepository")
 */
class DailyTask extends TaskAbstract
{
    use HasLengthFieldTrait;
    use HasLastDoneFieldTrait;

    /**
     * @var string
     * @Assert\Choice(choices = {"Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "all", "workday", "day_off"}, strict = true)
     * @ORM\Column(name="weekday", type="string", length=10, nullable=false, options={"default":"all"})
     */
    protected $weekday = 'all';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="time", type="time", nullable=true)
     */
    protected $time;


    /**
     * @return string
     */
    public function getWeekday(): string
    {
        return $this->weekday;
    }


    /**
     * @param string $weekday
     */
    public function setWeekday(string $weekday)
    {
        $this->weekday = $weekday;
    }


    /**
     * @return \DateTime
     */
    public function getTime(): ?\DateTime
    {
        return $this->time;
    }

    public function getFormattedTime(): ?string
    {
        return $this->getTime() ? $this->getTime()->format('H:i') : null;
    }


    /**
     * @param \DateTime $time
     */
    public function setTime(?\DateTime $time)
    {
        $this->time = $time;
    }

    public function checkDone(?\DateTime $date = null): bool
    {
        if (null === $this->getLastDone()) {
            return false;
        }

        return ($this->getLastDone()->format('Y-m-d') === ($date ?? new \DateTime)->format('Y-m-d'));

    }

    public function markAsDone(?\DateTime $date = null): void
    {
        $this->setLastDone($date ?? new \DateTime);
    }

    public function markUndone(?\DateTime $date = null): void
    {
        $this->setLastDone(null);
    }


}
