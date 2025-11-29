<?php

declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: junade
 * Date: 04/09/2017
 * Time: 19:56.
 */

namespace Cloudflare\API\Endpoints;

use Cloudflare\API\Adapter\Adapter;
use Cloudflare\API\Traits\BodyAccessorTrait;
use stdClass;

class IPs implements API
{
    use BodyAccessorTrait;

    public function __construct(private Adapter $adapter)
    {
    }

    public function listIPs(): stdClass
    {
        $ips = $this->adapter->get('ips');
        $this->body = \json_decode((string) $ips->getBody());

        return $this->body->result;
    }
}
