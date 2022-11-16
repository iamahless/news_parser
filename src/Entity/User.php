<?php

namespace App\Entity;

use App\Repository\UserRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
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
	 * @var DateTime $created
	 *
	 * @ORM\Column(name="created_at", type="datetime", nullable=false)
	 */
	private $createdAt;

	/**
	 * @var DateTime $updated
	 *
	 * @ORM\Column(name="updated_at", type="datetime", nullable=false)
	 */
	private $updatedAt;

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

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
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
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
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

	/**
	 * @ORM\PrePersist
	 * @ORM\PreUpdate
	 */
	public function updatedTimestamps(): void
	{
		$dateTimeNow = new DateTime('now');

		$this->setUpdatedAt($dateTimeNow);

		if ($this->getCreatedAt() === null) {
			$this->setCreatedAt($dateTimeNow);
		}
	}

	public function getCreatedAt() :?DateTime
	{
		return $this->createdAt;
	}

	public function setCreatedAt(DateTime $createdAt): self
	{
		$this->createdAt = $createdAt;

		return $this;
	}

	public function getUpdatedAt() :?DateTime
	{
		return $this->updatedAt;
	}

	public function setUpdatedAt(DateTime $updatedAt): self
	{
		$this->updatedAt = $updatedAt;

		return $this;
	}
}
