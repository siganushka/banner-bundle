<?php

declare(strict_types=1);

namespace Siganushka\BannerBundle\Media;

use Siganushka\MediaBundle\AbstractChannel;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Mapping\GenericMetadata;

class BannerImg extends AbstractChannel
{
    protected function loadConstraints(GenericMetadata $metadata): void
    {
        $constraint = new Image();
        // $constraint->minWidth = 640;
        // $constraint->maxWidth = 640;
        // $constraint->minHeight = 320;
        // $constraint->maxHeight = 320;
        $constraint->mimeTypes = ['image/png', 'image/jpeg', 'image/webp'];

        $metadata->addConstraint($constraint);
    }
}
