<?php

declare(strict_types=1);

namespace Cloudflare\API\Configurations;

class Certificate implements Configurations
{
    public const ORIGIN_RSA = 'origin-rsa';
    public const ORIGIN_ECC = 'origin-ecc';
    public const KEYLESS_CERTIFICATE = 'keyless-certificate';

    private array $config = [];

    public function getArray(): array
    {
        return $this->config;
    }

    /**
     * Array of hostnames or wildcard names (e.g., *.example.com) bound to the certificate
     * Example: $hostnames = ["example.com", "foo.example.com"].
     */
    public function setHostnames(array $hostnames): void
    {
        $this->config['hostnames'] = $hostnames;
    }

    /**
     * The number of days for which the certificate should be valid
     * Default value: 5475
     * Valid values: 7, 30, 90, 365, 730, 1095, 5475.
     */
    public function setRequestedValidity(int $validity): void
    {
        $this->config['requested_validity'] = $validity;
    }

    /**
     * Signature type desired on certificate ("origin-rsa" (rsa), "origin-ecc" (ecdsa), or "keyless-certificate" (for Keyless SSL servers)
     * Valid values: origin-rsa, origin-ecc, keyless-certificate.
     */
    public function setRequestType(string $type): void
    {
        $this->config['request_type'] = $type;
    }

    /**
     * The Certificate Signing Request (CSR). Must be newline-encoded.
     */
    public function setCsr(string $csr): void
    {
        $this->config['csr'] = $csr;
    }
}
