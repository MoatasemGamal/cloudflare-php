<?php

declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: Jurgen Coetsiers
 * Date: 21/10/2018
 * Time: 09:10.
 */

namespace Cloudflare\API\Endpoints;

use Cloudflare\API\Adapter\Adapter;

class TLS implements API
{
    public function __construct(private readonly Adapter $adapter)
    {
    }

    /**
     * Get the TLS Client Auth setting for the zone.
     *
     * @param string $zoneID The ID of the zone
     * @return string|false
     */
    public function getTLSClientAuth(string $zoneID): string|bool
    {
        $return = $this->adapter->get(
            'zones/' . $zoneID . '/settings/tls_client_auth',
        );
        $body = \json_decode((string) $return->getBody());
        if (isset($body->result)) {
            return $body->result->value;
        }
        return false;
    }

    /**
     * Enable TLS 1.3 for the zone.
     *
     * @param string $zoneID The ID of the zone
     */
    public function enableTLS13(string $zoneID): bool
    {
        $return = $this->adapter->patch(
            'zones/' . $zoneID . '/settings/tls_1_3',
            ['value' => 'on'],
        );
        $body = \json_decode((string) $return->getBody());
        return isset($body->success) && $body->success === true;
    }

    /**
     * Disable TLS 1.3 for the zone.
     *
     * @param string $zoneID The ID of the zone
     */
    public function disableTLS13(string $zoneID): bool
    {
        $return = $this->adapter->patch(
            'zones/' . $zoneID . '/settings/tls_1_3',
            ['value' => 'off'],
        );
        $body = \json_decode((string) $return->getBody());
        return isset($body->success) && $body->success === true;
    }

    /**
     * Update the minimum TLS version setting for the zone.
     *
     * @param string $zoneID The ID of the zone
     * @param string $minimumVersion The version to update to
     */
    public function changeMinimumTLSVersion(string $zoneID, $minimumVersion): bool
    {
        $return = $this->adapter->patch(
            'zones/' . $zoneID . '/settings/min_tls_version',
            [
                'value' => $minimumVersion,
            ],
        );
        $body = \json_decode((string) $return->getBody());
        return isset($body->success) && $body->success === true;
    }

    /**
     * Update the TLS Client Auth setting for the zone.
     *
     * @param string $zoneID The ID of the zone
     * @param string $value The value of the zone setting
     */
    public function updateTLSClientAuth(string $zoneID, $value): bool
    {
        $return = $this->adapter->patch(
            'zones/' . $zoneID . '/settings/tls_client_auth',
            [
                'value' => $value,
            ],
        );
        $body = \json_decode((string) $return->getBody());
        return isset($body->success) && $body->success === true;
    }
}
