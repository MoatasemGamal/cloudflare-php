<?php

declare(strict_types=1);

/**
 * Created by PhpStorm.
 * User: junade
 * Date: 06/06/2017
 * Time: 15:45.
 */

namespace Cloudflare\API\Endpoints;

use Cloudflare\API\Adapter\Adapter;
use Cloudflare\API\Traits\BodyAccessorTrait;
use stdClass;

class Zones implements API
{
    use BodyAccessorTrait;

    public function __construct(private Adapter $adapter)
    {
    }

    /**
     * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
     */
    public function addZone(string $name, bool $jumpStart = false, string $accountId = ''): stdClass
    {
        $options = [
            'name' => $name,
            'jump_start' => $jumpStart,
        ];

        if ($accountId !== '' && $accountId !== '0') {
            $options['account'] = [
                'id' => $accountId,
            ];
        }

        $user = $this->adapter->post('zones', $options);
        $this->body = \json_decode((string) $user->getBody());
        return $this->body->result;
    }

    public function activationCheck(string $zoneID): bool
    {
        $user = $this->adapter->put('zones/' . $zoneID . '/activation_check');
        $this->body = \json_decode((string) $user->getBody());
        return isset($this->body->result->id);
    }

    public function pause(string $zoneID): bool
    {
        $user = $this->adapter->patch('zones/' . $zoneID, ['paused' => true]);
        $this->body = \json_decode((string) $user->getBody());
        return isset($this->body->result->id);
    }

    public function unpause(string $zoneID): bool
    {
        $user = $this->adapter->patch('zones/' . $zoneID, ['paused' => false]);
        $this->body = \json_decode((string) $user->getBody());
        return isset($this->body->result->id);
    }

    public function getZoneById(
        string $zoneId,
    ): stdClass {
        $user = $this->adapter->get('zones/' . $zoneId);
        $this->body = \json_decode((string) $user->getBody());

        return (object)['result' => $this->body->result];
    }

    public function listZones(
        string $name = '',
        string $status = '',
        int $page = 1,
        int $perPage = 20,
        string $order = '',
        string $direction = '',
        string $match = 'all',
    ): stdClass {
        $query = [
            'page' => $page,
            'per_page' => $perPage,
            'match' => $match,
        ];

        if ($name !== '' && $name !== '0') {
            $query['name'] = $name;
        }

        if ($status !== '' && $status !== '0') {
            $query['status'] = $status;
        }

        if ($order !== '' && $order !== '0') {
            $query['order'] = $order;
        }

        if ($direction !== '' && $direction !== '0') {
            $query['direction'] = $direction;
        }

        $user = $this->adapter->get('zones', $query);
        $this->body = \json_decode((string) $user->getBody());

        return (object)['result' => $this->body->result, 'result_info' => $this->body->result_info];
    }

    public function getZoneID(string $name = ''): string
    {
        $zones = $this->listZones($name);

        if (\count($zones->result) < 1) {
            throw new EndpointException('Could not find zones with specified name.');
        }

        return $zones->result[0]->id;
    }

    /**
     * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
     */
    public function getAnalyticsDashboard(string $zoneID, string $since = '-10080', string $until = '0', bool $continuous = true): stdClass
    {
        $response = $this->adapter->get('zones/' . $zoneID . '/analytics/dashboard', ['since' => $since, 'until' => $until, 'continuous' => \var_export($continuous, true)]);

        $this->body = $response->getBody();

        return \json_decode($this->body)->result;
    }

    /**
     * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
     */
    public function changeDevelopmentMode(string $zoneID, bool $enable = false): bool
    {
        $response = $this->adapter->patch('zones/' . $zoneID . '/settings/development_mode', ['value' => $enable ? 'on' : 'off']);

        $this->body = \json_decode((string) $response->getBody());
        return (bool) $this->body->success;
    }

    /**
     * Return caching level settings.
     */
    public function getCachingLevel(string $zoneID): string
    {
        $response = $this->adapter->get('zones/' . $zoneID . '/settings/cache_level');

        $this->body = \json_decode((string) $response->getBody());

        return $this->body->result->value;
    }

    /**
     * Change caching level settings.
     * @param string $level (aggressive | basic | simplified)
     */
    public function setCachingLevel(string $zoneID, string $level = 'aggressive'): bool
    {
        $response = $this->adapter->patch('zones/' . $zoneID . '/settings/cache_level', ['value' => $level]);

        $this->body = \json_decode((string) $response->getBody());
        return (bool) $this->body->success;
    }

    /**
     * Purge Everything.
     *
     * @SuppressWarnings(PHPMD)
     */
    public function cachePurgeEverything(string $zoneID, bool $includeEnvironments = false): bool
    {
        if ($includeEnvironments) {
            $env = $this->adapter->get("zones/$zoneID/environments");
            $envs = \json_decode($env->getBody(), true);
            foreach ($envs['result']['environments'] as $env) {
                $this->adapter->post("zones/$zoneID/environments/{$env['ref']}/purge_cache", ['purge_everything' => true]);
            }
        }
        $user = $this->adapter->post('zones/' . $zoneID . '/purge_cache', ['purge_everything' => true]);

        $this->body = \json_decode((string) $user->getBody());
        return isset($this->body->result->id);
    }

    /**
     * @SuppressWarnings(PHPMD)
     */
    public function cachePurge(string $zoneID, ?array $files = null, ?array $tags = null, ?array $hosts = null, bool $includeEnvironments = false): bool
    {
        if ($files === null && $tags === null && $hosts === null) {
            throw new EndpointException('No files, tags or hosts to purge.');
        }

        $options = [];
        if (!\is_null($files)) {
            $options['files'] = $files;
        }

        if (!\is_null($tags)) {
            $options['tags'] = $tags;
        }

        if (!\is_null($hosts)) {
            $options['hosts'] = $hosts;
        }

        if ($includeEnvironments) {
            $env = $this->adapter->get("zones/$zoneID/environments");
            $envs = \json_decode($env->getBody(), true);
            foreach ($envs['result']['environments'] as $env) {
                $this->adapter->post("zones/$zoneID/environments/{$env['ref']}/purge_cache", $options);
            }
        }

        $user = $this->adapter->post('zones/' . $zoneID . '/purge_cache', $options);

        $this->body = \json_decode((string) $user->getBody());
        return isset($this->body->result->id);
    }

    /**
     * Delete Zone.
     */
    public function deleteZone(string $identifier): bool
    {
        $user = $this->adapter->delete('zones/' . $identifier);
        $this->body = \json_decode((string) $user->getBody());
        return isset($this->body->result->id);
    }
}
