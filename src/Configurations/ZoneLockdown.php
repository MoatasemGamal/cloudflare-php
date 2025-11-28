<?php

declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: junade
 * Date: 05/09/2017
 * Time: 13:43.
 */

namespace Cloudflare\API\Configurations;

class ZoneLockdown implements Configurations
{
    private array $configs = [];

    public function addIP(string $value): void
    {
        $this->configs[] = ['target' => 'ip', 'value' => $value];
    }

    public function addIPRange(string $value): void
    {
        $this->configs[] = ['target' => 'ip_range', 'value' => $value];
    }

    public function getArray(): array
    {
        return $this->configs;
    }
}
