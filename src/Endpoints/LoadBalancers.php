<?php

declare(strict_types=1);
/**
 * @author Martijn Smidt <martijn@squeezely.tech>
 * User: HemeraOne
 * Date: 13/05/2019
 */

namespace Cloudflare\API\Endpoints;

use Cloudflare\API\Adapter\Adapter;
use Cloudflare\API\Configurations\ConfigurationsException;
use Cloudflare\API\Configurations\LoadBalancer;
use Cloudflare\API\Traits\BodyAccessorTrait;

class LoadBalancers implements API
{
    use BodyAccessorTrait;

    public function __construct(private Adapter $adapter)
    {
    }

    public function listLoadBalancers(string $zoneID): mixed
    {
        $loadBalancers = $this->adapter->get('zones/' . $zoneID . '/load_balancers');
        $this->body = \json_decode($loadBalancers->getBody());

        return $this->body->result;
    }

    public function getLoadBalancerDetails(string $zoneID, string $loadBalancerID): mixed
    {
        $loadBalancer = $this->adapter->get('zones/' . $zoneID . '/load_balancers/' . $loadBalancerID);
        $this->body = \json_decode($loadBalancer->getBody());
        return $this->body->result;
    }

    /**
     * @throws ConfigurationsException
     */
    public function getLoadBalancerConfiguration(string $zoneID, string $loadBalancerID): LoadBalancer
    {
        $loadBalancer = $this->getLoadBalancerDetails($zoneID, $loadBalancerID);

        $lbConfiguration = new LoadBalancer($loadBalancer->name, $loadBalancer->default_pools, $loadBalancer->fallback_pool);
        $lbConfiguration->setSteeringPolicy($loadBalancer->steering_policy);
        if ($loadBalancer->enabled === true) {
            $lbConfiguration->enable();
        } elseif ($loadBalancer->enabled === false) {
            $lbConfiguration->disable();
        }

        if (\is_array($loadBalancer->pop_pools)) {
            $lbConfiguration->setPopPools($loadBalancer->pop_pools);
        }

        if (isset($loadBalancer->ttl)) {
            $lbConfiguration->setTtl($loadBalancer->ttl);
        }

        if (\is_array($loadBalancer->region_pools)) {
            $lbConfiguration->setRegionPools($loadBalancer->region_pools);
        }
        $lbConfiguration->setSessionAffinity($loadBalancer->session_affinity);
        $lbConfiguration->setDescription($loadBalancer->description);
        if ($loadBalancer->proxied === true) {
            $lbConfiguration->enableProxied();
        } elseif ($loadBalancer->proxied === false) {
            $lbConfiguration->disableProxied();
        }

        if (isset($loadBalancer->session_affinity_ttl)) {
            $lbConfiguration->setSessionAffinityTtl($loadBalancer->session_affinity_ttl);
        }

        return $lbConfiguration;
    }

    public function updateLoadBalancer(
        string $zoneID,
        string $loadBalancerID,
        LoadBalancer $lbConfiguration,
    ): bool {
        $options = $lbConfiguration->getArray();

        $query = $this->adapter->put('zones/' . $zoneID . '/load_balancers/' . $loadBalancerID, $options);

        $this->body = \json_decode($query->getBody());
        return isset($this->body->result->id);
    }

    public function createLoadBalancer(
        string $zoneID,
        LoadBalancer $lbConfiguration,
    ): bool {
        $options = $lbConfiguration->getArray();

        $query = $this->adapter->post('zones/' . $zoneID . '/load_balancers', $options);

        $this->body = \json_decode($query->getBody());
        return isset($this->body->result->id);
    }

    public function deleteLoadBalancer(string $zoneID, string $loadBalancerID): bool
    {
        $loadBalancer = $this->adapter->delete('zones/' . $zoneID . '/load_balancers/' . $loadBalancerID);

        $this->body = \json_decode($loadBalancer->getBody());
        return isset($this->body->result->id);
    }
}
