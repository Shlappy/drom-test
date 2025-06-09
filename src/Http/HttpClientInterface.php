<?php declare(strict_types=1);

namespace CommentsClient\Http;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;

interface HttpClientInterface
{
    /**
     * Создать и отправить HTTP GET запрос
     *
     * @param string|UriInterface $uri
     * @return ResponseInterface
     */
    public function get(UriInterface|string $uri): ResponseInterface;

    /**
     * Создать и отправить HTTP POST запрос
     *
     * @param string|UriInterface $uri
     * @param array $data
     * @return ResponseInterface
     */
    public function post(UriInterface|string $uri, array $data = []): ResponseInterface;

    /**
     * Создать и отправить HTTP PUT запрос
     *
     * @param string|UriInterface $uri
     * @param array $data
     * @return ResponseInterface
     */
    public function put(UriInterface|string $uri, array $data = []): ResponseInterface;
}