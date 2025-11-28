<?php

declare(strict_types=1);

use Cloudflare\API\Adapter\Adapter;
use Cloudflare\API\Endpoints\IPs;

/**
 * Created by PhpStorm.
 * User: junade
 * Date: 04/09/2017
 * Time: 20:16.
 */
class IPsTest extends TestCase
{
    public function testListIPs(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/listIPs.json');

        $mock = $this->getMockBuilder(Adapter::class)->getMock();
        $mock->method('get')->willReturn($response);

        $mock->expects($this->once())
            ->method('get')
            ->with(
                $this->equalTo('ips'),
            );

        $ipsMock = new IPs($mock);
        $ips = $ipsMock->listIPs();
        $this->assertObjectHasAttribute('ipv4_cidrs', $ips);
        $this->assertObjectHasAttribute('ipv6_cidrs', $ips);
        $this->assertObjectHasAttribute('ipv4_cidrs', $ipsMock->getBody()->result);
        $this->assertObjectHasAttribute('ipv6_cidrs', $ipsMock->getBody()->result);
    }
}
