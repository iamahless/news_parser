<?php

namespace App\Entity;

use App\Repository\PostRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PostRepository::class)
 */
class Post
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $link;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $excerpt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $imageUrl;

    /**
     * @ORM\Column(name="published_date", type="datetime")
     */
    private $publishedDate;

	/**
	 * @var DateTime $createdAr
	 *
	 * @ORM\Column(name="created_at", type="datetime", nullable=false)
	 */
	private $createdAt;

	/**
	 * @var DateTime $updatedAt
	 *
	 * @ORM\Column(name="updated_at", type="datetime", nullable=false)
	 */
	private $updatedAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(string $link): self
    {
        $this->link = $link;

        return $this;
    }

    public function getExcerpt(): ?string
    {
        return $this->excerpt;
    }

    public function setExcerpt(string $excerpt): self
    {
        $this->excerpt = $excerpt;

        return $this;
    }

    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }

    public function setImageUrl(string $imageUrl): self
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }

    public function getPublishedDate(): ?DateTime
    {
        return $this->publishedDate;
    }

    public function setPublishedDate(DateTime $publishedDate): self
    {
        $this->publishedDate = $publishedDate;

        return $this;
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
}
