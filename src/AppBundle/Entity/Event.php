<?php
declare(strict_types=1);

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Event
 *
 * @ORM\Table(name="events")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EventsRepository")
 */
class Event extends TaskAbstract
{
    use HasLengthFieldTrait;
    use HasDoneFieldTrait;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datetime", type="datetime")
     */
    protected $datetime;

    /**
     * @return \DateTime
     */
    public function getDateTime(): ?\DateTime
    {
        return $this->datetime;
    }


    /**
     * @param \DateTime $datetime
     */
    public function setDateTime(\DateTime $datetime): void
    {
        $this->datetime = $datetime;
    }

    public function getFormattedTime(): ?string
    {
        return $this->getDateTime() ? $this->getDateTime()->format('H:i') : null;
    }



    public function checkDone(?\DateTime $date = null): bool
    {
        return $this->isDone();

    }

    public function markAsDone(?\DateTime $date = null): void
    {
        $this->setDone(true);
    }

    public function markUndone(?\DateTime $date = null): void
    {
        $this->setDone(false);
    }


}
