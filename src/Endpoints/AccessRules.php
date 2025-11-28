<?php

declare(strict_types=1);

namespace Cloudflare\API\Endpoints;

use Cloudflare\API\Adapter\Adapter;
use Cloudflare\API\Configurations\Configurations;
use Cloudflare\API\Traits\BodyAccessorTrait;
use stdClass;

class AccessRules implements API
{
    use BodyAccessorTrait;

    public function __construct(private Adapter $adapter)
    {
    }

    /**
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function listRules(
        string $zoneID,
        string $scopeType = '',
        string $mode = '',
        string $configurationTarget = '',
        string $configurationValue = '',
        int $page = 1,
        int $perPage = 50,
        string $order = '',
        string $direction = '',
        string $match = 'all',
        string $notes = '',
    ): stdClass {
        $query = [
            'page' => $page,
            'per_page' => $perPage,
            'match' => $match,
        ];

        if ($scopeType !== '' && $scopeType !== '0') {
            $query['scope_type'] = $scopeType;
        }

        if ($mode !== '' && $mode !== '0') {
            $query['mode'] = $mode;
        }

        if ($configurationTarget !== '' && $configurationTarget !== '0') {
            $query['configuration_target'] = $configurationTarget;
        }

        if ($configurationValue !== '' && $configurationValue !== '0') {
            $query['configuration_value'] = $configurationValue;
        }

        if ($order !== '' && $order !== '0') {
            $query['order'] = $order;
        }

        if ($direction !== '' && $direction !== '0') {
            $query['direction'] = $direction;
        }

        if ($notes !== '' && $notes !== '0') {
            $query['notes'] = $notes;
        }

        $data = $this->adapter->get('zones/' . $zoneID . '/firewall/access_rules/rules', $query);
        $this->body = \json_decode($data->getBody());

        return (object)['result' => $this->body->result, 'result_info' => $this->body->result_info];
    }

    public function createRule(
        string $zoneID,
        string $mode,
        Configurations $configuration,
        ?string $notes = null,
    ): bool {
        $options = [
            'mode' => $mode,
            'configuration' => $configuration->getArray(),
        ];

        if ($notes !== null) {
            $options['notes'] = $notes;
        }

        $query = $this->adapter->post('zones/' . $zoneID . '/firewall/access_rules/rules', $options);

        $this->body = \json_decode($query->getBody());
        return isset($this->body->result->id);
    }

    public function updateRule(
        string $zoneID,
        string $ruleID,
        string $mode,
        ?string $notes = null,
    ): bool {
        $options = [
            'mode' => $mode,
        ];

        if ($notes !== null) {
            $options['notes'] = $notes;
        }

        $query = $this->adapter->patch('zones/' . $zoneID . '/firewall/access_rules/rules/' . $ruleID, $options);

        $this->body = \json_decode($query->getBody());
        return isset($this->body->result->id);
    }

    public function deleteRule(string $zoneID, string $ruleID, string $cascade = 'none'): bool
    {
        $options = [
            'cascade' => $cascade,
        ];

        $data = $this->adapter->delete('zones/' . $zoneID . '/firewall/access_rules/rules/' . $ruleID, $options);

        $this->body = \json_decode($data->getBody());
        return isset($this->body->result->id);
    }
}
