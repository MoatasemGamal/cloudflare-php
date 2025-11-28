<?php

declare(strict_types=1);

use Cloudflare\API\Adapter\Adapter;
use Cloudflare\API\Endpoints\FirewallSettings;

class FirewallSettingsTest extends TestCase
{
    public function testGetSecurityLevelSetting(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/getSecurityLevelSetting.json');

        $mock = $this->getMockBuilder(Adapter::class)->getMock();
        $mock->method('get')->willReturn($response);

        $mock->expects($this->once())
            ->method('get')
            ->with(
                $this->equalTo('zones/c2547eb745079dac9320b638f5e225cf483cc5cfdda41/settings/security_level'),
            );

        $firewallSettingsMock = new FirewallSettings($mock);
        $result = $firewallSettingsMock->getSecurityLevelSetting('c2547eb745079dac9320b638f5e225cf483cc5cfdda41');

        $this->assertEquals('medium', $result);
    }

    public function testGetChallengeTTLSetting(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/getChallengeTTLSetting.json');

        $mock = $this->getMockBuilder(Adapter::class)->getMock();
        $mock->method('get')->willReturn($response);

        $mock->expects($this->once())
            ->method('get')
            ->with(
                $this->equalTo('zones/c2547eb745079dac9320b638f5e225cf483cc5cfdda41/settings/challenge_ttl'),
            );

        $firewallSettingsMock = new FirewallSettings($mock);
        $result = $firewallSettingsMock->getChallengeTTLSetting('c2547eb745079dac9320b638f5e225cf483cc5cfdda41');

        $this->assertEquals(1800, $result);
    }

    public function testGetBrowserIntegrityCheckSetting(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/getBrowserIntegrityCheckSetting.json');

        $mock = $this->getMockBuilder(Adapter::class)->getMock();
        $mock->method('get')->willReturn($response);

        $mock->expects($this->once())
            ->method('get')
            ->with(
                $this->equalTo('zones/c2547eb745079dac9320b638f5e225cf483cc5cfdda41/settings/browser_check'),
            );

        $firewallSettingsMock = new FirewallSettings($mock);
        $result = $firewallSettingsMock->getBrowserIntegrityCheckSetting('c2547eb745079dac9320b638f5e225cf483cc5cfdda41');

        $this->assertEquals('on', $result);
    }

    public function testUpdateSecurityLevelSetting(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/updateSecurityLevelSetting.json');

        $mock = $this->getMockBuilder(Adapter::class)->getMock();
        $mock->method('patch')->willReturn($response);

        $mock->expects($this->once())
            ->method('patch')
            ->with(
                $this->equalTo('zones/c2547eb745079dac9320b638f5e225cf483cc5cfdda41/settings/security_level'),
                $this->equalTo(['value' => 'medium']),
            );

        $firewallSettingsMock = new FirewallSettings($mock);
        $result = $firewallSettingsMock->updateSecurityLevelSetting('c2547eb745079dac9320b638f5e225cf483cc5cfdda41', 'medium');

        $this->assertTrue($result);
    }

    public function testUpdateChallengeTTLSetting(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/updateChallengeTTLSetting.json');

        $mock = $this->getMockBuilder(Adapter::class)->getMock();
        $mock->method('patch')->willReturn($response);

        $mock->expects($this->once())
            ->method('patch')
            ->with(
                $this->equalTo('zones/c2547eb745079dac9320b638f5e225cf483cc5cfdda41/settings/challenge_ttl'),
                $this->equalTo(['value' => 1800]),
            );

        $firewallSettingsMock = new FirewallSettings($mock);
        $result = $firewallSettingsMock->updateChallengeTTLSetting('c2547eb745079dac9320b638f5e225cf483cc5cfdda41', 1800);

        $this->assertTrue($result);
    }

    public function testUpdateBrowserIntegrityCheckSetting(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/updateBrowserIntegrityCheckSetting.json');

        $mock = $this->getMockBuilder(Adapter::class)->getMock();
        $mock->method('patch')->willReturn($response);

        $mock->expects($this->once())
            ->method('patch')
            ->with(
                $this->equalTo('zones/c2547eb745079dac9320b638f5e225cf483cc5cfdda41/settings/browser_check'),
                $this->equalTo(['value' => 'on']),
            );

        $firewallSettingsMock = new FirewallSettings($mock);
        $result = $firewallSettingsMock->updateBrowserIntegrityCheckSetting('c2547eb745079dac9320b638f5e225cf483cc5cfdda41', 'on');

        $this->assertTrue($result);
    }
}
