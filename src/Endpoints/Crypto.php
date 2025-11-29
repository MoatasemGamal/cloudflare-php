<?php

declare(strict_types=1);

namespace Cloudflare\API\Endpoints;

use Cloudflare\API\Adapter\Adapter;

class Crypto implements API
{
    public function __construct(private readonly Adapter $adapter)
    {
    }

    /**
     * Get the Opportunistic Encryption feature for a zone.
     *
     * @param string $zoneID The ID of the zone
     * @return string|false
     */
    public function getOpportunisticEncryptionSetting(string $zoneID): string|bool
    {
        $return = $this->adapter->get(
            'zones/' . $zoneID . '/settings/opportunistic_encryption',
        );
        $body = \json_decode((string) $return->getBody());
        if (isset($body->result)) {
            return $body->result->value;
        }
        return false;
    }

    /**
     * Get the Onion Routing feature for a zone.
     *
     * @param string $zoneID The ID of the zone
     * @return string|false
     */
    public function getOnionRoutingSetting(string $zoneID): string|bool
    {
        $return = $this->adapter->get(
            'zones/' . $zoneID . '/settings/opportunistic_onion',
        );
        $body = \json_decode((string) $return->getBody());
        return $body->result ?? false;
    }

    /**
     * Update the Oppurtunistic Encryption setting for the zone.
     *
     * @param string $zoneID The ID of the zone
     * @param string $value The value of the zone setting
     */
    public function updateOpportunisticEncryptionSetting(string $zoneID, string $value): bool
    {
        $return = $this->adapter->patch(
            'zones/' . $zoneID . '/settings/opportunistic_encryption',
            [
                'value' => $value,
            ],
        );
        $body = \json_decode((string) $return->getBody());
        return isset($body->success) && $body->success === true;
    }

    /**
     * Update the Onion Routing setting for the zone.
     *
     * @param string $zoneID The ID of the zone
     * @param string $value The value of the zone setting
     */
    public function updateOnionRoutingSetting(string $zoneID, string $value): bool
    {
        $return = $this->adapter->patch(
            'zones/' . $zoneID . '/settings/opportunistic_onion',
            [
                'value' => $value,
            ],
        );
        $body = \json_decode((string) $return->getBody());
        return isset($body->success) && $body->success === true;
    }
}
