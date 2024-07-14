<?php

declare(strict_types=1);

namespace Siganushka\BannerBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class SiganushkaBannerBundle extends Bundle
{
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
}
