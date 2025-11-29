<?php

declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: junade
 * Date: 09/06/2017
 * Time: 15:14.
 */

namespace Cloudflare\API\Endpoints;

use Cloudflare\API\Adapter\Adapter;
use Cloudflare\API\Traits\BodyAccessorTrait;
use stdClass;

class DNS implements API
{
    use BodyAccessorTrait;

    public function __construct(private Adapter $adapter)
    {
    }

    /**
     * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
     */
    public function addRecord(
        string $zoneID,
        string $type,
        string $name,
        string $content,
        int $ttl = 0,
        bool $proxied = true,
        string $priority = '',
        array $data = [],
    ): bool {
        $options = [
            'type' => $type,
            'name' => $name,
            'content' => $content,
            'proxied' => $proxied,
        ];

        if ($ttl > 0) {
            $options['ttl'] = $ttl;
        }

        if (\is_numeric($priority)) {
            $options['priority'] = (int)$priority;
        }

        if ($data !== []) {
            $options['data'] = $data;
        }

        $user = $this->adapter->post('zones/' . $zoneID . '/dns_records', $options);

        $this->body = \json_decode((string) $user->getBody());
        return isset($this->body->result->id);
    }

    public function listRecords(
        string $zoneID,
        string $type = '',
        string $name = '',
        string $content = '',
        int $page = 1,
        int $perPage = 20,
        string $order = '',
        string $direction = '',
        string $match = 'all',
    ): stdClass {
        $query = [
            'page' => $page,
            'per_page' => $perPage,
            'match' => $match,
        ];

        if ($type !== '' && $type !== '0') {
            $query['type'] = $type;
        }

        if ($name !== '' && $name !== '0') {
            $query['name'] = $name;
        }

        if ($content !== '' && $content !== '0') {
            $query['content'] = $content;
        }

        if ($order !== '' && $order !== '0') {
            $query['order'] = $order;
        }

        if ($direction !== '' && $direction !== '0') {
            $query['direction'] = $direction;
        }

        $user = $this->adapter->get('zones/' . $zoneID . '/dns_records', $query);
        $this->body = \json_decode((string) $user->getBody());

        return (object)['result' => $this->body->result, 'result_info' => $this->body->result_info];
    }

    public function getRecordDetails(string $zoneID, string $recordID): stdClass
    {
        $user = $this->adapter->get('zones/' . $zoneID . '/dns_records/' . $recordID);
        $this->body = \json_decode((string) $user->getBody());
        return $this->body->result;
    }

    public function getRecordID(string $zoneID, string $type = '', string $name = ''): string
    {
        $records = $this->listRecords($zoneID, $type, $name);
        return $records->result[0]->id ?? false;
    }

    public function updateRecordDetails(string $zoneID, string $recordID, array $details): stdClass
    {
        $response = $this->adapter->put('zones/' . $zoneID . '/dns_records/' . $recordID, $details);
        $this->body = \json_decode((string) $response->getBody());
        return $this->body;
    }

    public function deleteRecord(string $zoneID, string $recordID): bool
    {
        $user = $this->adapter->delete('zones/' . $zoneID . '/dns_records/' . $recordID);

        $this->body = \json_decode((string) $user->getBody());
        return isset($this->body->result->id);
    }
}
