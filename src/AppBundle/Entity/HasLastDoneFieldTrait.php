<?php
declare(strict_types=1);

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


trait HasLastDoneFieldTrait
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_done", type="date", nullable=true)
     */
    private $last_done;


    /**
     * @return \DateTime
     */
    public function getLastDone(): ?\DateTime
    {
        return $this->last_done;
    }

    /**
     * @param \DateTime $last_done
     */
    public function setLastDone(?\DateTime $last_done)
    {
        $this->last_done = $last_done;
    }


}
