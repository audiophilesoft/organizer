<?php
declare(strict_types=1);

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


abstract class TaskAbstract implements TaskInterface
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", options={"unsigned":true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id = 0;

    /**
     * @var string
     * @Assert\Length(min=1, max=255)
     * @ORM\Column(name="name", type="string", length=255)
     */
    protected $name = '';

    /**
     * @var string
     * @Assert\Length(max=65535)
     * @ORM\Column(name="description", type="text", length=65535,  nullable=true)
     */
    protected $description = '';

    /**
     * @var int
     * @Assert\Range(min=-3, max=3)
     * @ORM\Column(name="priority", type="smallint", options={"default":0})
     */
    protected $priority = 0;


    /**
     * @return int
     */
    public function getPriority(): ?int
    {
        return $this->priority;
    }


    /**
     * @param int $priority
     */
    public function setPriority(int $priority): void
    {
        $this->priority = $priority;
    }


    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }


    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }


    /**
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }


    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }


    /**
     * @return string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }


    /**
     * @param string $description
     */
    public function setDescription(?string $description)
    {
        $this->description = $description;
    }

    abstract public function checkDone(?\DateTime $date = null): bool;

    abstract public function markAsDone(?\DateTime $date = null): void;

    abstract public function markUndone(?\DateTime $date = null): void;


}
