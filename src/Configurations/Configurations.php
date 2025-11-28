<?php

declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: junade
 * Date: 19/09/2017
 * Time: 15:23.
 */

namespace Cloudflare\API\Configurations;

interface Configurations
{
    public function getArray(): array;
}
