<?php

declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: junade
 * Date: 19/09/2017
 * Time: 16:50.
 */

namespace Cloudflare\API\Configurations;

class PageRulesActions implements Configurations
{
    private array $configs = [];

    public function setAlwaysOnline(bool $active): void
    {
        $this->addConfigurationOption('always_online', [
            'value' => $this->getBoolAsOnOrOff($active),
        ]);
    }

    public function setAlwaysUseHTTPS(bool $active): void
    {
        $this->addConfigurationOption('always_use_https', [
            'value' => $this->getBoolAsOnOrOff($active),
        ]);
    }

    public function setBrowserCacheTTL(int $ttl): void
    {
        $this->addConfigurationOption('browser_cache_ttl', [
            'value' => $ttl,
        ]);
    }

    public function setOriginCacheControl(bool $active): void
    {
        $this->addConfigurationOption('explicit_cache_control', [
            'value' => $this->getBoolAsOnOrOff($active),
        ]);
    }

    public function setBrowserIntegrityCheck(bool $active): void
    {
        $this->addConfigurationOption('browser_check', [
            'value' => $this->getBoolAsOnOrOff($active),
        ]);
    }

    public function setBypassCacheOnCookie(string $value): void
    {
        if (\preg_match('/^([a-zA-Z0-9\.=|_*-]+)$/i', $value) < 1) {
            throw new ConfigurationsException('Invalid cookie string.');
        }

        $this->addConfigurationOption('bypass_cache_on_cookie', [
            'value' => $value,
        ]);
    }

    public function setCacheByDeviceType(bool $active): void
    {
        $this->addConfigurationOption('cache_by_device_type', [
            'value' => $this->getBoolAsOnOrOff($active),
        ]);
    }

    public function setCacheKey(string $value): void
    {
        $this->addConfigurationOption('cache_key', [
            'value' => $value,
        ]);
    }

    public function setCacheLevel(string $value): void
    {
        if (!\in_array($value, ['bypass', 'basic', 'simplified', 'aggressive', 'cache_everything'], true)) {
            throw new ConfigurationsException('Invalid cache level');
        }

        $this->addConfigurationOption('cache_level', [
            'value' => $value,
        ]);
    }

    public function setCacheOnCookie(string $value): void
    {
        if (\preg_match('/^([a-zA-Z0-9\.=|_*-]+)$/i', $value) < 1) {
            throw new ConfigurationsException('Invalid cookie string.');
        }

        $this->addConfigurationOption('cache_on_cookie', [
            'value' => $value,
        ]);
    }

    public function setDisableApps(bool $active): void
    {
        $this->addConfigurationOption('disable_apps', [
            'value' => $this->getBoolAsOnOrOff($active),
        ]);
    }

    public function setDisablePerformance(bool $active): void
    {
        $this->addConfigurationOption('disable_performance', [
            'value' => $this->getBoolAsOnOrOff($active),
        ]);
    }

    public function setDisableSecurity(bool $active): void
    {
        $this->addConfigurationOption('disable_security', [
            'value' => $this->getBoolAsOnOrOff($active),
        ]);
    }

    public function setEdgeCacheTTL(int $value): void
    {
        if ($value > 2678400) {
            throw new ConfigurationsException('Edge Cache TTL too high.');
        }

        $this->addConfigurationOption('edge_cache_ttl', [
            'value' => $value,
        ]);
    }

    public function setEmailObfuscation(bool $active): void
    {
        $this->addConfigurationOption('disable_security', [
            'value' => $this->getBoolAsOnOrOff($active),
        ]);
    }

    public function setForwardingURL(int $statusCode, string $forwardingUrl): void
    {
        if (!\in_array($statusCode, ['301', '302'], true)) {
            throw new ConfigurationsException('Status Codes can only be 301 or 302.');
        }

        $this->addConfigurationOption('forwarding_url', [
            'value' => [
                'status_code' => $statusCode,
                'url' => $forwardingUrl,
            ],
        ]);
    }

    public function setHostHeaderOverride(string $value): void
    {
        $this->addConfigurationOption('host_header_override', [
            'value' => $value,
        ]);
    }

    public function setHotlinkProtection(bool $active): void
    {
        $this->addConfigurationOption('hotlink_protection', [
            'value' => $this->getBoolAsOnOrOff($active),
        ]);
    }

    public function setIPGeoLocationHeader(bool $active): void
    {
        $this->addConfigurationOption('ip_geolocation', [
            'value' => $this->getBoolAsOnOrOff($active),
        ]);
    }

    public function setMinification(bool $html, bool $css, bool $javascript): void
    {
        $this->addConfigurationOption('minification', [
            'html' => $this->getBoolAsOnOrOff($html),
            'css' => $this->getBoolAsOnOrOff($css),
            'js' => $this->getBoolAsOnOrOff($javascript),
        ]);
    }

    public function setMirage(bool $active): void
    {
        $this->addConfigurationOption('mirage', [
            'value' => $this->getBoolAsOnOrOff($active),
        ]);
    }

    public function setOriginErrorPagePassthru(bool $active): void
    {
        $this->addConfigurationOption('origin_error_page_pass_thru', [
            'value' => $this->getBoolAsOnOrOff($active),
        ]);
    }

    public function setQueryStringSort(bool $active): void
    {
        $this->addConfigurationOption('sort_query_string_for_cache', [
            'value' => $this->getBoolAsOnOrOff($active),
        ]);
    }

    public function setDisableRailgun(bool $active): void
    {
        $this->addConfigurationOption('disable_railgun', [
            'value' => $this->getBoolAsOnOrOff($active),
        ]);
    }

    public function setResolveOverride(string $value): void
    {
        $this->addConfigurationOption('resolve_override', [
            'value' => $value,
        ]);
    }

    public function setRespectStrongEtag(bool $active): void
    {
        $this->addConfigurationOption('respect_strong_etag', [
            'value' => $this->getBoolAsOnOrOff($active),
        ]);
    }

    public function setResponseBuffering(bool $active): void
    {
        $this->addConfigurationOption('response_buffering', [
            'value' => $this->getBoolAsOnOrOff($active),
        ]);
    }

    public function setRocketLoader(string $value): void
    {
        if (!\in_array($value, ['off', 'manual', 'automatic'], true)) {
            throw new ConfigurationsException('Rocket Loader can only be off, automatic, or manual.');
        }

        $this->addConfigurationOption('rocket_loader', [
            'value' => $value,
        ]);
    }

    public function setSecurityLevel(string $value): void
    {
        if (!\in_array($value, ['off', 'essentially_off', 'low', 'medium', 'high', 'under_attack'], true)) {
            throw new ConfigurationsException('Can only be set to off, essentially_off, low, medium, high or under_attack.');
        }

        $this->addConfigurationOption('security_level', [
            'value' => $value,
        ]);
    }

    public function setServerSideExcludes(bool $active): void
    {
        $this->addConfigurationOption('server_side_exclude', [
            'value' => $this->getBoolAsOnOrOff($active),
        ]);
    }

    public function setSmartErrors(bool $active): void
    {
        $this->addConfigurationOption('smart_errors', [
            'value' => $this->getBoolAsOnOrOff($active),
        ]);
    }

    public function setSSL(string $value): void
    {
        if (!\in_array($value, ['off', 'flexible', 'full', 'strict', 'origin_pull'], true)) {
            throw new ConfigurationsException('Can only be set to off, flexible, full, strict, origin_pull.');
        }

        $this->addConfigurationOption('ssl', [
            'value' => $value,
        ]);
    }

    public function setTrueClientIpHeader(bool $active): void
    {
        $this->addConfigurationOption('true_client_ip_header', [
            'value' => $this->getBoolAsOnOrOff($active),
        ]);
    }

    public function setWAF(bool $active): void
    {
        $this->addConfigurationOption('waf', [
            'value' => $this->getBoolAsOnOrOff($active),
        ]);
    }

    public function setAutomatedHTTPSRewrites(bool $active): void
    {
        $this->addConfigurationOption('automatic_https_rewrites', [
            'value' => $this->getBoolAsOnOrOff($active),
        ]);
    }

    public function setOpportunisticEncryption(bool $active): void
    {
        $this->addConfigurationOption('opportunistic_encryption', [
            'value' => $this->getBoolAsOnOrOff($active),
        ]);
    }

    public function getArray(): array
    {
        return $this->configs;
    }

    private function addConfigurationOption(string $setting, array $configuration): void
    {
        $configuration['id'] = $setting;

        $this->configs[] = $configuration;
    }

    private function getBoolAsOnOrOff(bool $value): string
    {
        return $value ? 'on' : 'off';
    }
}
