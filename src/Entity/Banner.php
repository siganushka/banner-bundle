<?php

declare(strict_types=1);

namespace Siganushka\BannerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Siganushka\Contracts\Doctrine\EnableInterface;
use Siganushka\Contracts\Doctrine\EnableTrait;
use Siganushka\Contracts\Doctrine\ResourceInterface;
use Siganushka\Contracts\Doctrine\ResourceTrait;
use Siganushka\Contracts\Doctrine\SortableInterface;
use Siganushka\Contracts\Doctrine\SortableTrait;
use Siganushka\Contracts\Doctrine\TimestampableInterface;
use Siganushka\Contracts\Doctrine\TimestampableTrait;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\MappedSuperclass
 */
class Banner implements ResourceInterface, EnableInterface, SortableInterface, TimestampableInterface
{
    use EnableTrait;
    use ResourceTrait;
    use SortableTrait;
    use TimestampableTrait;

    /**
     * @ORM\Column(type="string")
     *
     * @Groups({"banner"})
     */
    private ?string $title = null;

    /**
     * @ORM\Column(type="string")
     *
     * @Groups({"banner"})
     */
    private ?string $img = null;

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getImg(): ?string
    {
        return $this->img;
    }

    public function setImg(?string $img): self
    {
        $this->img = $img;

        return $this;
    }
}
