<?php

namespace Http\Client\Exception;

use Http\Client\BatchResult;
use Http\Client\Exception;
use Psr\Http\Message\RequestInterface;

/**
 * This exception is thrown when a batch of requests led to at least one failure.
 *
 * It holds the response/exception pairs and gives access to a BatchResult with the successful responses.
 *
*@author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
final class BatchException extends \RuntimeException implements Exception
{
    /**
     * @var BatchResult
     */
    private $result;

    /**
     * @var \SplObjectStorage
     */
    private $exceptions;

    public function __construct()
    {
        $this->exceptions = new \SplObjectStorage();
    }

    /**
     * Returns the BatchResult that contains those responses that where successful.
     *
     * Note that the BatchResult may contains 0 responses if all requests failed.
     *
     * @return BatchResult
     *
     * @throws \RuntimeException If the BatchResult is not available
     */
    public function getResult()
    {
        if (!isset($this->result)) {
            throw new \RuntimeException('BatchResult is not available');
        }

        return $this->result;
    }

    /**
     * Sets the successful response list
     *
     * @param BatchResult $result
     *
     * @throws \RuntimeException If the BatchResult is already set
     *
     * @internal
     */
    public function setResult(BatchResult $result)
    {
        if (isset($this->result)) {
            throw new \RuntimeException('BatchResult is already set');
        }

        $this->result = $result;
    }

    /**
     * Checks if a request is successful
     *
     * @param RequestInterface $request
     *
     * @return boolean
     */
    public function isSuccessful(RequestInterface $request)
    {
        return $this->getResult()->hasResponseFor($request);
    }

    /**
     * Checks if a request is failed
     *
     * @param RequestInterface $request
     *
     * @return boolean
     */
    public function isFailed(RequestInterface $request)
    {
        return $this->exceptions->contains($request);
    }

    /**
     * Returns all exceptions
     *
     * @return Exception[]
     */
    public function getExceptions()
    {
        $exceptions = [];

        foreach ($this->exceptions as $request) {
            $exceptions[] = $this->exceptions[$request];
        }

        return $exceptions;
    }

    /**
     * Returns an exception for a request
     *
     * @param RequestInterface $request
     *
     * @return Exception
     *
     * @throws \UnexpectedValueException If request is not found
     */
    public function getExceptionFor(RequestInterface $request)
    {
        try {
            return $this->exceptions[$request];
        } catch (\UnexpectedValueException $e) {
            throw new \UnexpectedValueException('Request not found', $e->getCode(), $e);
        }
    }

    /**
     * Checks if there is an exception for a request
     *
     * @param RequestInterface $request
     *
     * @return boolean
     */
    public function hasExceptionFor(RequestInterface $request)
    {
        return $this->exceptions->contains($request);
    }

    /**
     * Adds an exception
     *
     * @param RequestInterface  $request
     * @param Exception         $exception
     */
    public function addException(RequestInterface $request, Exception $exception)
    {
        $this->exceptions->attach($request, $exception);
    }
}
