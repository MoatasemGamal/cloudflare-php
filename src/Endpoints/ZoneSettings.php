<?php

declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: paul.adams
 * Date: 2019-02-22
 * Time: 23:28.
 */

namespace Cloudflare\API\Endpoints;

use Cloudflare\API\Adapter\Adapter;
use Cloudflare\API\Traits\BodyAccessorTrait;

class ZoneSettings implements API
{
    use BodyAccessorTrait;

    public function __construct(private Adapter $adapter)
    {
    }

    public function getMinifySetting(string $zoneID)
    {
        $return = $this->adapter->get(
            'zones/' . $zoneID . '/settings/minify',
        );
        $body = \json_decode((string) $return->getBody());

        if ($body->success) {
            return $body->result->value;
        }

        return false;
    }

    public function getRocketLoaderSetting(string $zoneID)
    {
        $return = $this->adapter->get(
            'zones/' . $zoneID . '/settings/rocket_loader',
        );
        $body = \json_decode((string) $return->getBody());

        if ($body->success) {
            return $body->result->value;
        }

        return false;
    }

    public function getAlwaysOnlineSetting(string $zoneID)
    {
        $return = $this->adapter->get(
            'zones/' . $zoneID . '/settings/always_online',
        );
        $body = \json_decode((string) $return->getBody());

        if ($body->success) {
            return $body->result->value;
        }

        return false;
    }

    public function getEmailObfuscationSetting(string $zoneID)
    {
        $return = $this->adapter->get(
            'zones/' . $zoneID . '/settings/email_obfuscation',
        );
        $body = \json_decode((string) $return->getBody());

        if ($body->success) {
            return $body->result->value;
        }

        return false;
    }

    public function getServerSideExcludeSetting(string $zoneID)
    {
        $return = $this->adapter->get(
            'zones/' . $zoneID . '/settings/server_side_exclude',
        );
        $body = \json_decode((string) $return->getBody());

        if ($body->success) {
            return $body->result->value;
        }

        return false;
    }

    public function getHotlinkProtectionSetting(string $zoneID)
    {
        $return = $this->adapter->get(
            'zones/' . $zoneID . '/settings/hotlink_protection',
        );
        $body = \json_decode((string) $return->getBody());

        if ($body->success) {
            return $body->result->value;
        }

        return false;
    }

    public function getBrowserCacheTtlSetting(string $zoneID)
    {
        $return = $this->adapter->get(
            'zones/' . $zoneID . '/settings/browser_cache_ttl',
        );
        $body = \json_decode((string) $return->getBody());

        if ($body->success) {
            return $body->result->value;
        }

        return false;
    }

    public function updateBrowserCacheTtlSetting(string $zoneID, $value): bool
    {
        $return = $this->adapter->patch(
            'zones/' . $zoneID . '/settings/browser_cache_ttl',
            [
                'value' => $value,
            ],
        );
        $body = \json_decode((string) $return->getBody());
        return (bool) $body->success;
    }

    public function updateMinifySetting(string $zoneID, $html, $css, $javascript): bool
    {
        $return = $this->adapter->patch(
            'zones/' . $zoneID . '/settings/minify',
            [
                'value' => [
                    'html' => $html,
                    'css' => $css,
                    'js' => $javascript,
                ],
            ],
        );
        $body = \json_decode((string) $return->getBody());
        return (bool) $body->success;
    }

    public function updateRocketLoaderSetting(string $zoneID, $value): bool
    {
        $return = $this->adapter->patch(
            'zones/' . $zoneID . '/settings/rocket_loader',
            [
                'value' => $value,
            ],
        );
        $body = \json_decode((string) $return->getBody());
        return (bool) $body->success;
    }

    public function updateAlwaysOnlineSetting(string $zoneID, $value): bool
    {
        $return = $this->adapter->patch(
            'zones/' . $zoneID . '/settings/always_online',
            [
                'value' => $value,
            ],
        );
        $body = \json_decode((string) $return->getBody());
        return (bool) $body->success;
    }

    public function updateEmailObfuscationSetting(string $zoneID, $value): bool
    {
        $return = $this->adapter->patch(
            'zones/' . $zoneID . '/settings/email_obfuscation',
            [
                'value' => $value,
            ],
        );
        $body = \json_decode((string) $return->getBody());
        return (bool) $body->success;
    }

    public function updateHotlinkProtectionSetting(string $zoneID, $value): bool
    {
        $return = $this->adapter->patch(
            'zones/' . $zoneID . '/settings/hotlink_protection',
            [
                'value' => $value,
            ],
        );
        $body = \json_decode((string) $return->getBody());
        return (bool) $body->success;
    }

    public function updateServerSideExcludeSetting(string $zoneID, $value)
    {
        $return = $this->adapter->patch(
            'zones/' . $zoneID . '/settings/server_side_exclude',
            [
                'value' => $value,
            ],
        );
        $body = \json_decode((string) $return->getBody());

        if ($body->success) {
            return $body->result->value;
        }

        return false;
    }
}
