<?php

declare(strict_types=1);

namespace Cloudflare\API\Configurations;

class FirewallRuleOptions implements Configurations
{
    protected $configs = [
        'paused' => false,
        'action' => 'block',
    ];

    public function getArray(): array
    {
        return $this->configs;
    }

    public function setPaused(bool $paused): void
    {
        $this->configs['paused'] = $paused;
    }

    public function setActionBlock(): void
    {
        $this->configs['action'] = 'block';
    }

    public function setActionAllow(): void
    {
        $this->configs['action'] = 'allow';
    }

    public function setActionChallenge(): void
    {
        $this->configs['action'] = 'challenge';
    }

    public function setActionJsChallenge(): void
    {
        $this->configs['action'] = 'js_challenge';
    }

    public function setActionLog(): void
    {
        $this->configs['action'] = 'log';
    }
}
