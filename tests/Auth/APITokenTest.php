<?php

declare(strict_types=1);

use Cloudflare\API\Auth\APIToken;

/**
 * User: czPechy
 * Date: 30/07/2018
 * Time: 23:25.
 */
class APITokenTest extends TestCase
{
    public function testGetHeaders(): void
    {
        $auth = new APIToken('zKq9RDO6PbCjs6PRUXF3BoqFi3QdwY36C2VfOaRy');
        $headers = $auth->getHeaders();

        $this->assertArrayHasKey('Authorization', $headers);

        $this->assertEquals('Bearer zKq9RDO6PbCjs6PRUXF3BoqFi3QdwY36C2VfOaRy', $headers['Authorization']);

        $this->assertCount(1, $headers);
    }
}
