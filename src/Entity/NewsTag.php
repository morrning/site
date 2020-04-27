<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NewsTagRepository")
 */
class NewsTag
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
    private $tagName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $tagUseCount;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\NewsContent", mappedBy="tags")
     */
    private $newsContents;

    public function __construct()
    {
        $this->newsContents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTagName(): ?string
    {
        return $this->tagName;
    }

    public function setTagName(string $tagName): self
    {
        $this->tagName = $tagName;

        return $this;
    }

    public function getTagUseCount(): ?string
    {
        return $this->tagUseCount;
    }

    public function setTagUseCount(?string $tagUseCount): self
    {
        $this->tagUseCount = $tagUseCount;

        return $this;
    }

    /**
     * @return Collection|NewsContent[]
     */
    public function getNewsContents(): Collection
    {
        return $this->newsContents;
    }

    public function addNewsContent(NewsContent $newsContent): self
    {
        if (!$this->newsContents->contains($newsContent)) {
            $this->newsContents[] = $newsContent;
            $newsContent->addTag($this);
        }

        return $this;
    }

    public function removeNewsContent(NewsContent $newsContent): self
    {
        if ($this->newsContents->contains($newsContent)) {
            $this->newsContents->removeElement($newsContent);
            $newsContent->removeTag($this);
        }

        return $this;
    }
}
