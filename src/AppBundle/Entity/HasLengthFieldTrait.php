<?php
declare(strict_types=1);

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


trait HasLengthFieldTrait
{


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="length", type="time", nullable=true)
     */
    protected $length;


    /**
     * @return \DateTime
     */
    public function getLength(): ?\DateTime
    {
        return $this->length;
    }


    /**
     * @param \DateTime $length
     */
    public function setLength(?\DateTime $length)
    {
        $this->length = $length;
    }

}
