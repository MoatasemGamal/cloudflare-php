<?php

declare(strict_types=1);

use Cloudflare\API\Adapter\Adapter;
use Cloudflare\API\Endpoints\AccountRoles;

class AccountRolesTest extends TestCase
{
    public function testListAccountRoles(): void
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/listAccountRoles.json');

        $adapter = $this->getMockBuilder(Adapter::class)->getMock();
        $adapter->method('get')->willReturn($response);

        $adapter->expects($this->once())
            ->method('get')
            ->with($this->equalTo('accounts/023e105f4ecef8ad9ca31a8372d0c353/roles'));

        $roles = new AccountRoles($adapter);
        $result = $roles->listAccountRoles('023e105f4ecef8ad9ca31a8372d0c353');

        $this->assertObjectHasProperty('result', $result);
        $this->assertObjectHasProperty('result_info', $result);

        $this->assertEquals('3536bcfad5faccb999b47003c79917fb', $result->result[0]->id);
        $this->assertEquals(1, $result->result_info->page);
        $this->assertEquals('3536bcfad5faccb999b47003c79917fb', $roles->getBody()->result[0]->id);
    }
}
