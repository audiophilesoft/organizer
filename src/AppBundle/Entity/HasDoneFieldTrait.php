<?php
declare(strict_types=1);

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


trait HasDoneFieldTrait
{


    /**
     * @var bool
     *
     * @ORM\Column(name="`show`", type="boolean", options={"default":false})
     */
    protected $done = false;

    /**
     * @return bool
     */
    public function isDone(): bool
    {
        return $this->done;
    }


    /**
     * @param bool $done
     */
    public function setDone(bool $value): void
    {
        $this->done = $value;
    }
}
