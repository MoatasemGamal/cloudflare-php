<?php

declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: junade
 * Date: 09/06/2017
 * Time: 16:17.
 */

namespace Cloudflare\API\Endpoints;

use Cloudflare\API\Adapter\Adapter;
use Cloudflare\API\Configurations\PageRulesActions;
use Cloudflare\API\Configurations\PageRulesTargets;
use Cloudflare\API\Traits\BodyAccessorTrait;
use stdClass;

class PageRules implements API
{
    use BodyAccessorTrait;

    public function __construct(private Adapter $adapter)
    {
    }

    /**
     * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
     */
    public function createPageRule(
        string $zoneID,
        PageRulesTargets $target,
        PageRulesActions $actions,
        bool $active = true,
        ?int $priority = null,
    ): bool {
        $options = [
            'targets' => $target->getArray(),
            'actions' => $actions->getArray(),
        ];

        $options['status'] = $active === true ? 'active' : 'disabled';

        if ($priority !== null) {
            $options['priority'] = $priority;
        }

        $query = $this->adapter->post('zones/' . $zoneID . '/pagerules', $options);

        $this->body = \json_decode($query->getBody());
        return isset($this->body->result->id);
    }

    public function listPageRules(
        string $zoneID,
        ?string $status = null,
        ?string $order = null,
        ?string $direction = null,
        ?string $match = null,
    ): array {
        if ($status !== null && !\in_array($status, ['active', 'disabled'], true)) {
            throw new EndpointException('Page Rules can only be listed by status of active or disabled.');
        }

        if ($order !== null && !\in_array($order, ['status', 'priority'], true)) {
            throw new EndpointException('Page Rules can only be ordered by status or priority.');
        }

        if ($direction !== null && !\in_array($direction, ['asc', 'desc'], true)) {
            throw new EndpointException('Direction of Page Rule ordering can only be asc or desc.');
        }

        if ($match !== null && !\in_array($match, ['all', 'any'], true)) {
            throw new EndpointException('Match can only be any or all.');
        }

        $query = [
            'status' => $status,
            'order' => $order,
            'direction' => $direction,
            'match' => $match,
        ];

        $user = $this->adapter->get('zones/' . $zoneID . '/pagerules', $query);
        $this->body = \json_decode($user->getBody());

        return $this->body->result;
    }

    public function getPageRuleDetails(string $zoneID, string $ruleID): stdClass
    {
        $user = $this->adapter->get('zones/' . $zoneID . '/pagerules/' . $ruleID);
        $this->body = \json_decode($user->getBody());
        return $this->body->result;
    }

    public function editPageRule(
        string $zoneID,
        string $ruleID,
        PageRulesTargets $target,
        PageRulesActions $actions,
        ?bool $active = null,
        ?int $priority = null,
    ): bool {
        $options = [];
        $options['targets'] = $target->getArray();
        $options['actions'] = $actions->getArray();

        if ($active !== null) {
            $options['status'] = $active === true ? 'active' : 'disabled';
        }

        if ($priority !== null) {
            $options['priority'] = $priority;
        }

        $query = $this->adapter->put('zones/' . $zoneID . '/pagerules/' . $ruleID, $options);

        $this->body = \json_decode($query->getBody());
        return isset($this->body->result->id);
    }

    public function updatePageRule(
        string $zoneID,
        string $ruleID,
        ?PageRulesTargets $target = null,
        ?PageRulesActions $actions = null,
        ?bool $active = null,
        ?int $priority = null,
    ): bool {
        $options = [];

        if ($target instanceof PageRulesTargets) {
            $options['targets'] = $target->getArray();
        }

        if ($actions instanceof PageRulesActions) {
            $options['actions'] = $actions->getArray();
        }

        if ($active !== null) {
            $options['status'] = $active === true ? 'active' : 'disabled';
        }

        if ($priority !== null) {
            $options['priority'] = $priority;
        }

        $query = $this->adapter->patch('zones/' . $zoneID . '/pagerules/' . $ruleID, $options);

        $this->body = \json_decode($query->getBody());
        return isset($this->body->result->id);
    }

    public function deletePageRule(string $zoneID, string $ruleID): bool
    {
        $user = $this->adapter->delete('zones/' . $zoneID . '/pagerules/' . $ruleID);

        $this->body = \json_decode($user->getBody());
        return isset($this->body->result->id);
    }
}
