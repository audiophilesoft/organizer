<?php
declare(strict_types=1);

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Until
 *
 * @ORM\Table(name="until")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UntilRepository")
 */
class Until extends TaskAbstract
{
    use HasDoneFieldTrait;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="deadline", type="date")
     */
    private $deadline;

    /**
     * @return \DateTime
     */
    public function getDeadline(): ?\DateTime
    {
        return $this->deadline;
    }

    /**
     * @param \DateTime $deadline
     */
    public function setDeadline(\DateTime $deadline)
    {
        $this->deadline = $deadline;
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
