<?php
declare(strict_types=1);

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Todo
 *
 * @ORM\Table(name="todo")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TodoRepository")
 */
class Todo extends TaskAbstract
{
    use HasDoneFieldTrait;



    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    protected $date;

    /**
     * @return \DateTime
     */
    public function getDate(): ?\DateTime
    {
        return $this->date;
    }


    /**
     * @param \DateTime $date
     */
    public function setDate(\DateTime $date): void
    {
        $this->date = $date;
    }


    public function checkDone(?\DateTime $date = null): bool
    {
        return $this->isDone();

    }

    public function markAsDone(?\DateTime $date = null): void
    {
        $this->setDone(true);
        $this->setDate($date ?? new \DateTime);
    }

    public function markUndone(?\DateTime $date = null): void
    {
        $this->setDone(false);
    }
}
