<?php

declare(strict_types=1);

namespace Siganushka\BannerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Siganushka\BannerBundle\Repository\BannerRepository;
use Siganushka\Contracts\Doctrine\EnableInterface;
use Siganushka\Contracts\Doctrine\EnableTrait;
use Siganushka\Contracts\Doctrine\ResourceInterface;
use Siganushka\Contracts\Doctrine\ResourceTrait;
use Siganushka\Contracts\Doctrine\SortableInterface;
use Siganushka\Contracts\Doctrine\SortableTrait;
use Siganushka\Contracts\Doctrine\TimestampableInterface;
use Siganushka\Contracts\Doctrine\TimestampableTrait;
use Siganushka\MediaBundle\Entity\Media;

/**
 * @ORM\Entity(repositoryClass=BannerRepository::class)
 */
class Banner implements ResourceInterface, EnableInterface, SortableInterface, TimestampableInterface
{
    use EnableTrait;
    use ResourceTrait;
    use SortableTrait;
    use TimestampableTrait;

    /**
     * @ORM\Column(type="string")
     */
    private ?string $title = null;

    /**
     * @ORM\ManyToOne(targetEntity=Media::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private ?Media $img = null;

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getImg(): ?Media
    {
        return $this->img;
    }

    public function setImg(?Media $img): self
    {
        $this->img = $img;

        return $this;
    }
}
