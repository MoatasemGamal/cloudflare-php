<?php

declare(strict_types=1);

use Cloudflare\API\Configurations\Certificate;
use PHPUnit\Framework\TestCase;

class CertificateTest extends TestCase
{
    public function testGetArray(): void
    {
        $certificate = new Certificate();
        $certificate->setHostnames(['foo.com', '*.bar.com']);
        $certificate->setRequestType(Certificate::ORIGIN_ECC);
        $certificate->setRequestedValidity(365);
        $certificate->setCsr('some-csr-encoded-text');

        $array = $certificate->getArray();
        $this->assertEquals(['foo.com', '*.bar.com'], $array['hostnames']);
        $this->assertEquals('origin-ecc', $array['request_type']);
        $this->assertEquals(365, $array['requested_validity']);
        $this->assertEquals('some-csr-encoded-text', $array['csr']);
    }
}
