<?php

declare(strict_types=1);

namespace Cloudflare\API\Configurations;

class DNSAnalytics implements Configurations
{
    protected $configs = [];

    public function getArray(): array
    {
        return $this->configs;
    }

    public function setDimensions(array $dimensions): void
    {
        if ($dimensions !== []) {
            $this->configs['dimensions'] = \implode(',', $dimensions);
        }
    }

    public function setMetrics(array $metrics): void
    {
        if ($metrics !== []) {
            $this->configs['metrics'] = \implode(',', $metrics);
        }
    }

    public function setSince(string $since): void
    {
        if ($since !== '' && $since !== '0') {
            $this->configs['since'] = $since;
        }
    }

    public function setUntil(string $until): void
    {
        if ($until !== '' && $until !== '0') {
            $this->configs['until'] = $until;
        }
    }

    public function setSorting(array $sorting): void
    {
        if ($sorting !== []) {
            $this->configs['sort'] = \implode(',', $sorting);
        }
    }

    public function setFilters(string $filters): void
    {
        if ($filters !== '' && $filters !== '0') {
            $this->configs['filters'] = $filters;
        }
    }

    public function setLimit(int $limit): void
    {
        if ($limit !== 0) {
            $this->configs['limit'] = $limit;
        }
    }

    public function setTimeDelta(string $timeDelta): void
    {
        if ($timeDelta !== '' && $timeDelta !== '0') {
            $this->configs['time_delta'] = $timeDelta;
        }
    }
}
