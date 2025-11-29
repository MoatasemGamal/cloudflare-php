<?php

declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: junade
 * Date: 18/03/2018
 * Time: 21:46.
 */

namespace Cloudflare\API\Endpoints;

use Cloudflare\API\Adapter\Adapter;
use Cloudflare\API\Traits\BodyAccessorTrait;
use stdClass;

class CustomHostnames implements API
{
    use BodyAccessorTrait;

    public function __construct(private Adapter $adapter)
    {
    }

    /**
     * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
     */
    public function addHostname(
        string $zoneID,
        string $hostname,
        string $sslMethod = 'http',
        string $sslType = 'dv',
        array $sslSettings = [],
        string $customOriginServer = '',
        bool $wildcard = false,
        string $bundleMethod = '',
        array $customSsl = [],
    ): stdClass {
        $options = [
            'hostname' => $hostname,
            'ssl' => [
                'method' => $sslMethod,
                'type' => $sslType,
                'settings' => $sslSettings,
                'wildcard' => $wildcard,
            ],
        ];

        if ($customOriginServer !== '' && $customOriginServer !== '0') {
            $options['custom_origin_server'] = $customOriginServer;
        }

        if ($bundleMethod !== '' && $bundleMethod !== '0') {
            $options['ssl']['bundle_method'] = $bundleMethod;
        }

        if (!empty($customSsl['key'])) {
            $options['ssl']['custom_key'] = $customSsl['key'];
        }

        if (!empty($customSsl['certificate'])) {
            $options['ssl']['custom_certificate'] = $customSsl['certificate'];
        }

        $zone = $this->adapter->post('zones/' . $zoneID . '/custom_hostnames', $options);
        $this->body = \json_decode((string) $zone->getBody());
        return $this->body->result;
    }

    public function listHostnames(
        string $zoneID,
        string $hostname = '',
        string $hostnameID = '',
        int $page = 1,
        int $perPage = 20,
        string $order = '',
        string $direction = '',
        int $ssl = 0,
    ): stdClass {
        $query = [
            'page' => $page,
            'per_page' => $perPage,
            'ssl' => $ssl,
        ];

        if ($hostname !== '' && $hostname !== '0') {
            $query['hostname'] = $hostname;
        }

        if ($hostnameID !== '' && $hostnameID !== '0') {
            $query['id'] = $hostnameID;
        }

        if ($order !== '' && $order !== '0') {
            $query['order'] = $order;
        }

        if ($direction !== '' && $direction !== '0') {
            $query['direction'] = $direction;
        }

        $zone = $this->adapter->get('zones/' . $zoneID . '/custom_hostnames', $query);
        $this->body = \json_decode((string) $zone->getBody());

        return (object)['result' => $this->body->result, 'result_info' => $this->body->result_info];
    }

    public function getHostname(string $zoneID, string $hostnameID): mixed
    {
        $zone = $this->adapter->get('zones/' . $zoneID . '/custom_hostnames/' . $hostnameID);
        $this->body = \json_decode((string) $zone->getBody());

        return $this->body->result;
    }

    /**
     * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function updateHostname(
        string $zoneID,
        string $hostnameID,
        string $sslMethod = '',
        string $sslType = '',
        array $sslSettings = [],
        string $customOriginServer = '',
        ?bool $wildcard = null,
        string $bundleMethod = '',
        array $customSsl = [],
    ): stdClass {
        $query = [];
        $options = [];

        if ($sslMethod !== '' && $sslMethod !== '0') {
            $query['method'] = $sslMethod;
        }

        if ($sslType !== '' && $sslType !== '0') {
            $query['type'] = $sslType;
        }

        if ($sslSettings !== []) {
            $query['settings'] = $sslSettings;
        }

        if (!\is_null($wildcard)) {
            $query['wildcard'] = $wildcard;
        }

        if ($bundleMethod !== '' && $bundleMethod !== '0') {
            $query['bundle_method'] = $bundleMethod;
        }

        if (!empty($customSsl['key'])) {
            $query['custom_key'] = $customSsl['key'];
        }

        if (!empty($customSsl['certificate'])) {
            $query['custom_certificate'] = $customSsl['certificate'];
        }

        if ($query !== []) {
            $options = [
                'ssl' => $query,
            ];
        }

        if ($customOriginServer !== '' && $customOriginServer !== '0') {
            $options['custom_origin_server'] = $customOriginServer;
        }

        $zone = $this->adapter->patch('zones/' . $zoneID . '/custom_hostnames/' . $hostnameID, $options);
        $this->body = \json_decode((string) $zone->getBody());
        return $this->body->result;
    }

    public function deleteHostname(string $zoneID, string $hostnameID): stdClass
    {
        $zone = $this->adapter->delete('zones/' . $zoneID . '/custom_hostnames/' . $hostnameID);
        $this->body = \json_decode((string) $zone->getBody());
        return $this->body;
    }

    public function getFallbackOrigin(string $zoneID): stdClass
    {
        $zone = $this->adapter->get('zones/' . $zoneID . '/custom_hostnames/fallback_origin');
        $this->body = \json_decode((string) $zone->getBody());

        return $this->body->result;
    }
}
