<?php

declare(strict_types=1);
/**
 * User: junade
 * Date: 13/01/2017
 * Time: 16:06.
 */

namespace Cloudflare\API\Adapter;

use Cloudflare\API\Auth\Auth;
use Psr\Http\Message\ResponseInterface;

/**
 * Interface Adapter.
 * @package Cloudflare\API\Adapter
 * Note that the $body fields expect a JSON key value store.
 */
interface Adapter
{
    /**
     * Sends a GET request.
     * Per Robustness Principle - not including the ability to send a body with a GET request (though possible in the
     * RFCs, it is never useful).
     */
    public function get(string $uri, array $data = [], array $headers = []): ResponseInterface;

    public function post(string $uri, array $data = [], array $headers = []): ResponseInterface;

    public function put(string $uri, array $data = [], array $headers = []): ResponseInterface;

    public function patch(string $uri, array $data = [], array $headers = []): ResponseInterface;

    public function delete(string $uri, array $data = [], array $headers = []): ResponseInterface;
}
