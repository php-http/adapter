<?php

namespace Http\Client\Exception;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Thrown when a response was received but has an error status code.
 *
 * This exception always provides the request and response objects.
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class HttpException extends RequestException
{
    /**
     * @var ResponseInterface
     */
    protected $response;

    /**
     * @param string            $message
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param \Exception|null   $previous
     */
    public function __construct(
        $message,
        RequestInterface $request,
        ResponseInterface $response,
        \Exception $previous = null
    ) {
        $this->response = $response;
        $this->code = $response->getStatusCode();


        parent::__construct($message, $request, $previous);
    }

    /**
     * Returns the response
     *
     * @return ResponseInterface
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * Factory method to create a new exception with a normalized error message
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param \Exception|null   $previous
     *
     * @return HttpException
     */
    public static function create(
        RequestInterface $request,
        ResponseInterface $response,
        \Exception $previous = null
    ) {
        $message = sprintf(
            '[url] %s [http method] %s [status code] %s [reason phrase] %s',
            $request->getRequestTarget(),
            $request->getMethod(),
            $response->getStatusCode(),
            $response->getReasonPhrase()
        );

        return new self($message, $request, $response, $previous);
    }
}
