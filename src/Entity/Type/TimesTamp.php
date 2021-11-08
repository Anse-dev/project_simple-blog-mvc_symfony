<?php


namespace App\Entity\Type;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\HasLifecycleCallbacks()
 * Trait TimesTamp
 * @package App\Entity\Type
 */
trait TimesTamp
{
    /**
     * @var \DateTime
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private \DateTime $createdAt;

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    /**
     * @ORM\PrePersist()
     * @return $this
     */
    public function setCreatedAt($date = null): self
    {
        $this->createdAt = new \DateTime();

        return $this;
    }

}