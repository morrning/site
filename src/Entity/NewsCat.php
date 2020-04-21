<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NewsCatRepository")
 */
class NewsCat
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
    private $catName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $catUrl;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\NewsContent", mappedBy="cat")
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

    public function getCatName(): ?string
    {
        return $this->catName;
    }

    public function setCatName(string $catName): self
    {
        $this->catName = $catName;

        return $this;
    }

    public function getCatUrl(): ?string
    {
        return $this->catUrl;
    }

    public function setCatUrl(string $catUrl): self
    {
        $this->catUrl = $catUrl;

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
            $newsContent->setCat($this);
        }

        return $this;
    }

    public function removeNewsContent(NewsContent $newsContent): self
    {
        if ($this->newsContents->contains($newsContent)) {
            $this->newsContents->removeElement($newsContent);
            // set the owning side to null (unless already changed)
            if ($newsContent->getCat() === $this) {
                $newsContent->setCat(null);
            }
        }

        return $this;
    }
}
