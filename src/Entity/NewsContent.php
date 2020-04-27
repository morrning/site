<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NewsContentRepository")
 */
class NewsContent
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $body;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $des;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\NewsCat", inversedBy="newsContents")
     */
    private $cat;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $dateSubmit;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SysUser", inversedBy="newsContents")
     * @ORM\JoinColumn(nullable=false)
     */
    private $submitter;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $pictureBanner;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $kywords;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $canComment;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $url;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $viewCount;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\NewsComment", mappedBy="post", orphanRemoval=true)
     */
    private $newsComments;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\NewsTag", inversedBy="newsContents")
     */
    private $tags;

    public function __construct()
    {
        $this->newsComments = new ArrayCollection();
        $this->tags = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(?string $body): self
    {
        $this->body = $body;

        return $this;
    }

    public function getDes(): ?string
    {
        return $this->des;
    }

    public function setDes(?string $des): self
    {
        $this->des = $des;

        return $this;
    }

    public function getCat(): ?NewsCat
    {
        return $this->cat;
    }

    public function setCat(?NewsCat $cat): self
    {
        $this->cat = $cat;

        return $this;
    }

    public function getDateSubmit(): ?string
    {
        return $this->dateSubmit;
    }

    public function setDateSubmit(string $dateSubmit): self
    {
        $this->dateSubmit = $dateSubmit;

        return $this;
    }

    public function getSubmitter(): ?SysUser
    {
        return $this->submitter;
    }

    public function setSubmitter(?SysUser $submitter): self
    {
        $this->submitter = $submitter;

        return $this;
    }

    public function getPictureBanner(): ?string
    {
        return $this->pictureBanner;
    }

    public function setPictureBanner(?string $pictureBanner): self
    {
        $this->pictureBanner = $pictureBanner;

        return $this;
    }

    public function getKywords(): ?string
    {
        return $this->kywords;
    }

    public function setKywords(?string $kywords): self
    {
        $this->kywords = $kywords;

        return $this;
    }

    public function getCanComment(): ?bool
    {
        return $this->canComment;
    }

    public function setCanComment(?bool $canComment): self
    {
        $this->canComment = $canComment;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getViewCount(): ?string
    {
        return $this->viewCount;
    }

    public function setViewCount(string $viewCount): self
    {
        $this->viewCount = $viewCount;

        return $this;
    }

    /**
     * @return Collection|NewsComment[]
     */
    public function getNewsComments(): Collection
    {
        return $this->newsComments;
    }

    public function addNewsComment(NewsComment $newsComment): self
    {
        if (!$this->newsComments->contains($newsComment)) {
            $this->newsComments[] = $newsComment;
            $newsComment->setPost($this);
        }

        return $this;
    }

    public function removeNewsComment(NewsComment $newsComment): self
    {
        if ($this->newsComments->contains($newsComment)) {
            $this->newsComments->removeElement($newsComment);
            // set the owning side to null (unless already changed)
            if ($newsComment->getPost() === $this) {
                $newsComment->setPost(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|NewsTag[]
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(NewsTag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
        }

        return $this;
    }

    public function removeTag(NewsTag $tag): self
    {
        if ($this->tags->contains($tag)) {
            $this->tags->removeElement($tag);
        }

        return $this;
    }
}
