<?php

declare(strict_types=1);

namespace Cloudflare\API\Endpoints;

use Cloudflare\API\Adapter\Adapter;
use Cloudflare\API\Configurations\Certificate as CertificateConfig;
use Cloudflare\API\Traits\BodyAccessorTrait;
use stdClass;

class Certificates implements API
{
    use BodyAccessorTrait;

    public function __construct(private Adapter $adapter)
    {
    }

    /**
     * List all existing Origin CA certificates for a given zone.
     *
     * @return array
     */
    public function listCertificates(string $zoneID): stdClass
    {
        $certificates = $this->adapter->get('certificates', ['zone_id' => $zoneID]);
        $this->body = \json_decode((string) $certificates->getBody());

        return (object)['result' => $this->body->result];
    }

    /**
     * Get an existing Origin CA certificate by its serial number.
     */
    public function getCertificate(string $certificateID, string $zoneID): mixed
    {
        $certificates = $this->adapter->get('certificates/' . $certificateID, ['zone_id' => $zoneID]);
        $this->body = \json_decode((string) $certificates->getBody());

        return (object)['result' => $this->body->result];
    }

    /**
     * Revoke an existing Origin CA certificate by its serial number.
     */
    public function revokeCertificate(string $certificateID, string $zoneID): bool
    {
        $certificates = $this->adapter->delete('certificates/' . $certificateID, ['zone_id' => $zoneID]);
        $this->body = \json_decode((string) $certificates->getBody());
        return isset($this->body->result->id);
    }

    /**
     * Create an Origin CA certificate.
     */
    public function createCertificate(CertificateConfig $config): bool
    {
        $certificate = $this->adapter->post('certificates', $config->getArray());

        $this->body = \json_decode((string) $certificate->getBody());
        return isset($this->body->result->id);
    }
}
