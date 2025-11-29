<?php

declare(strict_types=1);

use Cloudflare\API\Adapter\Adapter;
use Cloudflare\API\Endpoints\Zones;

class ZoneCacheTest extends TestCase
{
    public function testCachePurgeEverything(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/cachePurgeEverything.json');

        $mock = $this->getMockBuilder(Adapter::class)->getMock();
        $mock->method('post')->willReturn($response);

        $mock->expects($this->once())
            ->method('post')
            ->with(
                $this->equalTo('zones/c2547eb745079dac9320b638f5e225cf483cc5cfdda41/purge_cache'),
                $this->equalTo(['purge_everything' => true]),
            );

        $zones = new Zones($mock);
        $result = $zones->cachePurgeEverything('c2547eb745079dac9320b638f5e225cf483cc5cfdda41');

        $this->assertTrue($result);
        $this->assertEquals('023e105f4ecef8ad9ca31a8372d0c353', $zones->getBody()->result->id);
    }

    public function testCachePurgeHost(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/cachePurgeHost.json');

        $mock = $this->getMockBuilder(Adapter::class)->getMock();
        $mock->method('post')->willReturn($response);

        $mock->expects($this->once())
            ->method('post')
            ->with(
                $this->equalTo('zones/c2547eb745079dac9320b638f5e225cf483cc5cfdda41/purge_cache'),
                $this->equalTo(
                    [
                        'files' => [],
                        'tags' => [],
                        'hosts' => ['dash.cloudflare.com'],
                    ],
                ),
            );

        $zones = new Zones($mock);
        $result = $zones->cachePurge('c2547eb745079dac9320b638f5e225cf483cc5cfdda41', [], [], ['dash.cloudflare.com']);

        $this->assertTrue($result);
        $this->assertEquals('023e105f4ecef8ad9ca31a8372d0c353', $zones->getBody()->result->id);
    }

    public function testCachePurge(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/cachePurge.json');

        $mock = $this->getMockBuilder(Adapter::class)->getMock();
        $mock->method('post')->willReturn($response);

        $mock->expects($this->once())
            ->method('post')
            ->with(
                $this->equalTo('zones/c2547eb745079dac9320b638f5e225cf483cc5cfdda41/purge_cache'),
                $this->equalTo([
                    'files' => [
                        'https://example.com/file.jpg',
                    ],
                ]),
            );

        $zones = new Zones($mock);
        $result = $zones->cachePurge('c2547eb745079dac9320b638f5e225cf483cc5cfdda41', [
            'https://example.com/file.jpg',
        ]);

        $this->assertTrue($result);
        $this->assertEquals('023e105f4ecef8ad9ca31a8372d0c353', $zones->getBody()->result->id);
    }

    public function testCachePurgeIncludingEnvironments(): void
    {
        $envResp = $this->getPsr7JsonResponseForFixture('Endpoints/getEnvironments.json');
        $cacheResp = $this->getPsr7JsonResponseForFixture('Endpoints/cachePurge.json');
        $mock = $this->getMockBuilder(Adapter::class)->getMock();

        $mock->expects($this->once())
            ->method('get')
            ->willReturn($envResp)
            ->with(
                $this->equalTo('zones/c2547eb745079dac9320b638f5e225cf483cc5cfdda41/environments'),
            );

        // Track the post calls
        $postCallCount = 0;
        $expectedPostCalls = [
            ['zones/c2547eb745079dac9320b638f5e225cf483cc5cfdda41/environments/first/purge_cache', ['files' => ['https://example.com/file.jpg']]],
            ['zones/c2547eb745079dac9320b638f5e225cf483cc5cfdda41/environments/second/purge_cache', ['files' => ['https://example.com/file.jpg']]],
            ['zones/c2547eb745079dac9320b638f5e225cf483cc5cfdda41/environments/third/purge_cache', ['files' => ['https://example.com/file.jpg']]],
            ['zones/c2547eb745079dac9320b638f5e225cf483cc5cfdda41/purge_cache', ['files' => ['https://example.com/file.jpg']]],
        ];

        $mock->expects($this->exactly(4))
            ->method('post')
            ->willReturnCallback(function ($uri, $data) use ($cacheResp, &$postCallCount, $expectedPostCalls) {
                $this->assertEquals($expectedPostCalls[$postCallCount][0], $uri);
                $this->assertEquals($expectedPostCalls[$postCallCount][1], $data);
                $postCallCount++;
                return $cacheResp;
            });

        $zones = new Zones($mock);
        $result = $zones->cachePurge('c2547eb745079dac9320b638f5e225cf483cc5cfdda41', [
            'https://example.com/file.jpg',
        ], null, null, true);

        $this->assertTrue($result);
        $this->assertEquals('023e105f4ecef8ad9ca31a8372d0c353', $zones->getBody()->result->id);
    }

    public function testCachePurgeEverythingIncludingEnvironments(): void
    {
        $envResp = $this->getPsr7JsonResponseForFixture('Endpoints/getEnvironments.json');
        $cacheResp = $this->getPsr7JsonResponseForFixture('Endpoints/cachePurgeEverything.json');
        $mock = $this->getMockBuilder(Adapter::class)->getMock();

        $mock->expects($this->once())
            ->method('get')
            ->willReturn($envResp)
            ->with(
                $this->equalTo('zones/c2547eb745079dac9320b638f5e225cf483cc5cfdda41/environments'),
            );

        // Track the post calls  
        $postCallCount = 0;
        $expectedPostCalls = [
            ['zones/c2547eb745079dac9320b638f5e225cf483cc5cfdda41/environments/first/purge_cache', ['purge_everything' => true]],
            ['zones/c2547eb745079dac9320b638f5e225cf483cc5cfdda41/environments/second/purge_cache', ['purge_everything' => true]],
            ['zones/c2547eb745079dac9320b638f5e225cf483cc5cfdda41/environments/third/purge_cache', ['purge_everything' => true]],
            ['zones/c2547eb745079dac9320b638f5e225cf483cc5cfdda41/purge_cache', ['purge_everything' => true]],
        ];

        $mock->expects($this->exactly(4))
            ->method('post')
            ->willReturnCallback(function ($uri, $data) use ($cacheResp, &$postCallCount, $expectedPostCalls) {
                $this->assertEquals($expectedPostCalls[$postCallCount][0], $uri);
                $this->assertEquals($expectedPostCalls[$postCallCount][1], $data);
                $postCallCount++;
                return $cacheResp;
            });

        $zones = new Zones($mock);
        $result = $zones->cachePurgeEverything('c2547eb745079dac9320b638f5e225cf483cc5cfdda41', true);

        $this->assertTrue($result);
        $this->assertEquals('023e105f4ecef8ad9ca31a8372d0c353', $zones->getBody()->result->id);
    }
}
