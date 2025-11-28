<?php

declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: junade
 * Date: 19/09/2017
 * Time: 15:22.
 */

namespace Cloudflare\API\Configurations;

class UARules implements Configurations
{
    private array $configs = [];

    public function addUA(string $value): void
    {
        $this->configs[] = ['target' => 'ua', 'value' => $value];
    }

    public function getArray(): array
    {
        return $this->configs;
    }
}
