<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\PostRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Controller\PostPublishController;
use App\Controller\PostCountController;


/**
 * @ORM\Entity(repositoryClass=PostRepository::class)
 * @ApiResource(
 *     normalizationContext={"groups"={"read:collection"}},
 *     denormalizationContext={"groups"={"write:Post"}},
 *     attributes={"pagination_items_per_page"=2},
 *     collectionOperations={
 *     "get",
 *     "post",
 *     "count"={
 *          "method"="get",
 *          "path"="/posts/count",
 *          "controller"=PostCountController::class,
 *          "paginations_enabled"=false
 *     }
 *     },
 *     itemOperations={
 *     "put",
 *     "delete",
 *     "get"={
 *     "normalization_context"={"groups"={"read:collection","read:item","read:Post"}}
 *     },
 *     "publish"={
 *          "method"="POST",
 *          "path"="/posts/{id}/publish",
 *          "controller"=PostPublishController::class
 *      }
 * }
 * )
 * @ApiFilter(SearchFilter::class, properties={"id": "exact", "title": "partial"})
 */
class Post
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"read:collection"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read:collection", "write:Post"})
     * @Assert\Length(min=5)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read:collection", "write:Post"})
     * @Assert\Length(min=5)
     */
    private $slug;

    /**
     * @ORM\Column(type="text")
     * @Groups({"read:item", "write:Post"})
     */
    private $content;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"read:item"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="posts", cascade={"persist"})
     * @Groups({"read:item", "write:Post"})
     */
    private $category;

    /**
     * @ORM\Column(type="boolean", options={"default":"0"})
     * @Groups({"read:collection"})
     */
    private $online = false;


    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }


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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getOnline(): ?bool
    {
        return $this->online;
    }

    public function setOnline(bool $online): self
    {
        $this->online = $online;

        return $this;
    }
}
