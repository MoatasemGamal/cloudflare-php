<?php

declare(strict_types=1);

namespace Cloudflare\API\Configurations;

class AccessRules implements Configurations
{
    private ?array $config = null;

    public function setIP(string $value): void
    {
        $this->config = ['target' => 'ip', 'value' => $value];
    }

    public function setIPRange(string $value): void
    {
        $this->config = ['target' => 'ip_range', 'value' => $value];
    }

    public function setCountry(string $value): void
    {
        $this->config = ['target' => 'country', 'value' => $value];
    }

    public function setASN(string $value): void
    {
        $this->config = ['target' => 'asn', 'value' => $value];
    }

    public function getArray(): array
    {
        return $this->config;
    }
}
