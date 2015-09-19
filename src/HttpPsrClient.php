<?php

namespace Http\Client;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Sends one or more PSR-7 Request
 *
 * @author GeLo <geloen.eric@gmail.com>
 */
interface HttpPsrClient
{
    /**
     * Sends a PSR request
     *
     * @param RequestInterface $request
     * @param array            $options
     *
     * @return ResponseInterface
     *
     * @throws Exception
     */
    public function sendRequest(RequestInterface $request, array $options = []);

    /**
     * Sends PSR requests
     *
     * @param RequestInterface[] $requests
     * @param array              $options
     *
     * @return ResponseInterface[]
     *
     * @throws Exception
     */
    public function sendRequests(array $requests, array $options = []);
}