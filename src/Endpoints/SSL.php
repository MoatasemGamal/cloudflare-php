<?php

declare(strict_types=1);

namespace Cloudflare\API\Endpoints;

use Cloudflare\API\Adapter\Adapter;

class SSL implements API
{
    public function __construct(private readonly Adapter $adapter)
    {
    }

    /**
     * Get the SSL setting for the zone.
     *
     * @param string $zoneID The ID of the zone
     * @return string|false
     */
    public function getSSLSetting(string $zoneID): string|bool
    {
        $return = $this->adapter->get(
            'zones/' . $zoneID . '/settings/ssl',
        );
        $body = \json_decode((string) $return->getBody());
        if (isset($body->result)) {
            return $body->result->value;
        }
        return false;
    }

    /**
     * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
     *
     * Get SSL Verification Info for a Zone
     *
     * @param string $zoneID The ID of the zone
     * @param bool $retry Immediately retry SSL Verification
     * @return array|false
     */
    public function getSSLVerificationStatus(string $zoneID, bool $retry = false): object|false
    {
        $return = $this->adapter->get(
            'zones/' . $zoneID . '/ssl/verification',
            [
                'retry' => $retry,
            ],
        );

        $body = \json_decode((string) $return->getBody());
        if (isset($body->result)) {
            return $body;
        }
        return false;
    }

    /**
     * Get the HTTPS Redirect setting for the zone.
     *
     * @param string $zoneID The ID of the zone
     * @return string|false
     */
    public function getHTTPSRedirectSetting(string $zoneID): string|bool
    {
        $return = $this->adapter->get(
            'zones/' . $zoneID . '/settings/always_use_https',
        );
        $body = \json_decode((string) $return->getBody());
        return $body->result ?? false;
    }

    /**
     * Get the HTTPS Rewrite setting for the zone.
     *
     * @param string $zoneID The ID of the zone
     * @return string|false
     */
    public function getHTTPSRewritesSetting(string $zoneID): string|bool
    {
        $return = $this->adapter->get(
            'zones/' . $zoneID . '/settings/automatic_https_rewrites',
        );
        $body = \json_decode((string) $return->getBody());
        return $body->result ?? false;
    }

    /**
     * Update the SSL setting for the zone.
     *
     * @param string $zoneID The ID of the zone
     * @param string $value The value of the zone setting
     */
    public function updateSSLSetting(string $zoneID, string $value): bool
    {
        $return = $this->adapter->patch(
            'zones/' . $zoneID . '/settings/ssl',
            [
                'value' => $value,
            ],
        );
        $body = \json_decode((string) $return->getBody());
        return isset($body->success) && $body->success === true;
    }

    /**
     * Update the HTTPS Redirect setting for the zone.
     *
     * @param string $zoneID The ID of the zone
     * @param string $value The value of the zone setting
     */
    public function updateHTTPSRedirectSetting(string $zoneID, string $value): bool
    {
        $return = $this->adapter->patch(
            'zones/' . $zoneID . '/settings/always_use_https',
            [
                'value' => $value,
            ],
        );
        $body = \json_decode((string) $return->getBody());
        return isset($body->success) && $body->success === true;
    }

    /**
     * Update the HTTPS Rewrite setting for the zone.
     *
     * @param string $zoneID The ID of the zone
     * @param string $value The value of the zone setting
     */
    public function updateHTTPSRewritesSetting(string $zoneID, string $value): bool
    {
        $return = $this->adapter->patch(
            'zones/' . $zoneID . '/settings/automatic_https_rewrites',
            [
                'value' => $value,
            ],
        );
        $body = \json_decode((string) $return->getBody());
        return isset($body->success) && $body->success === true;
    }

    /**
     * Update the SSL certificate pack validation method.
     *
     * @param string $zoneID The ID of the zone
     * @param string $certPackUUID The certificate pack UUID
     * @param string $validationMethod The verification method
     */
    public function updateSSLCertificatePackValidationMethod(string $zoneID, string $certPackUUID, string $validationMethod): bool
    {
        $return = $this->adapter->patch(
            'zones/' . $zoneID . '/ssl/verification/' . $certPackUUID,
            [
                'validation_method' => $validationMethod,
            ],
        );
        $body = \json_decode((string) $return->getBody());
        return isset($body->success) && $body->success === true;
    }
}
