<?php
declare(strict_types=1);

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;



/**
 * Ponder
 *
 * @ORM\Table(name="ponder")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PonderRepository")
 */
class Ponder implements TaskInterface
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id = 0;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @Assert\Length(max=255)
     */
    protected $title = '';

    /**
     * @var string
     * @Assert\Length(max=65535)
     * @ORM\Column(name="description", type="text", length=65535, nullable=true)
     */
    protected $details = '';

    /**
     * @var bool
     *
     * @ORM\Column(name="`show`", type="boolean", options={"default":true})
     */
    protected $show = true;


    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }


    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }


    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }


    /**
     * @param string $title
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
    }


    /**
     * @return string
     */
    public function getDetails(): ?string
    {
        return $this->details;
    }


    /**
     * @param string $details
     */
    public function setDetails(?string $details)
    {
        $this->details = $details;
    }


    /**
     * @return bool
     */
    public function isShow(): bool
    {
        return $this->show;
    }


    /**
     * @param bool $show
     */
    public function setShow(bool $show)
    {
        $this->show = $show;
    }


}
