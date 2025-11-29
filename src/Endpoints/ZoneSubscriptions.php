<?php

declare(strict_types=1);

namespace Cloudflare\API\Endpoints;

use Cloudflare\API\Adapter\Adapter;
use Cloudflare\API\Traits\BodyAccessorTrait;
use stdClass;

class ZoneSubscriptions implements API
{
    use BodyAccessorTrait;

    public function __construct(private Adapter $adapter)
    {
    }

    public function listZoneSubscriptions(string $zoneId): stdClass
    {
        $user = $this->adapter->get('zones/' . $zoneId . '/subscriptions');
        $this->body = \json_decode((string) $user->getBody());

        return (object)[
            'result' => $this->body->result,
        ];
    }

    public function addZoneSubscription(string $zoneId, string $ratePlanId = ''): stdClass
    {
        $options = [];

        if (($ratePlanId === '' || $ratePlanId === '0') === false) {
            $options['rate_plan'] = [
                'id' => $ratePlanId,
            ];
        }

        $existingSubscription = $this->listZoneSubscriptions($zoneId);
        $method = empty($existingSubscription->result) ? 'post' : 'put';

        $subscription = $this->adapter->{$method}('zones/' . $zoneId . '/subscription', $options);
        $this->body = \json_decode((string) $subscription->getBody());

        return $this->body->result;
    }
}
