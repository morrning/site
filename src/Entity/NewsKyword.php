<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NewsKywordRepository")
 */
class NewsKyword
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $keyName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $useCount;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getKeyName(): ?string
    {
        return $this->keyName;
    }

    public function setKeyName(string $keyName): self
    {
        $this->keyName = $keyName;

        return $this;
    }

    public function getUseCount(): ?string
    {
        return $this->useCount;
    }

    public function setUseCount(string $useCount): self
    {
        $this->useCount = $useCount;

        return $this;
    }
}
