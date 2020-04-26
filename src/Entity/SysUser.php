<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SysUserRepository")
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class SysUser implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $fullName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $profilePic;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\NewsContent", mappedBy="submitter", orphanRemoval=true)
     */
    private $newsContents;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\NewsComment", mappedBy="user")
     */
    private $newsComments;

    public function __construct()
    {
        $this->newsContents = new ArrayCollection();
        $this->newsComments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    public function setFullName(string $fullName): self
    {
        $this->fullName = $fullName;

        return $this;
    }

    public function getProfilePic(): ?string
    {
        return $this->profilePic;
    }

    public function setProfilePic(?string $profilePic): self
    {
        $this->profilePic = $profilePic;

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
            $newsContent->setSubmitter($this);
        }

        return $this;
    }

    public function removeNewsContent(NewsContent $newsContent): self
    {
        if ($this->newsContents->contains($newsContent)) {
            $this->newsContents->removeElement($newsContent);
            // set the owning side to null (unless already changed)
            if ($newsContent->getSubmitter() === $this) {
                $newsContent->setSubmitter(null);
            }
        }

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
            $newsComment->setUser($this);
        }

        return $this;
    }

    public function removeNewsComment(NewsComment $newsComment): self
    {
        if ($this->newsComments->contains($newsComment)) {
            $this->newsComments->removeElement($newsComment);
            // set the owning side to null (unless already changed)
            if ($newsComment->getUser() === $this) {
                $newsComment->setUser(null);
            }
        }

        return $this;
    }
}
