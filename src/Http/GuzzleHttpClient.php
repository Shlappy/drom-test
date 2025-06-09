<?php declare(strict_types=1);

namespace CommentsClient\Http;

use CommentsClient\Utils\Logger\LoggerInterface;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\BadResponseException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;

class GuzzleHttpClient implements HttpClientInterface
{
    private GuzzleClient $client;

    public function __construct(
        private LoggerInterface $logger,
        string $baseUri,
        ?GuzzleClient $guzzleClient = null,
    ) {
        $this->client = $guzzleClient ?? new GuzzleClient(['base_uri' => $baseUri]);
    }

    /**
     * Создать и отправить HTTP GET запрос
     *
     * @param string|UriInterface $uri
     * @return ResponseInterface
     */
    public function get(UriInterface|string $uri): ResponseInterface
    {
        return $this->request('GET', $uri);
    }

    /**
     * Создать и отправить HTTP POST запрос
     *
     * @param string|UriInterface $uri
     * @param array $data
     * @return ResponseInterface
     */
    public function post(UriInterface|string $uri, array $data = []): ResponseInterface
    {
        return $this->request('POST', $uri, $data);
    }

    /**
     * Создать и отправить HTTP PUT запрос
     *
     * @param string|UriInterface $uri
     * @param array $data
     * @return ResponseInterface
     */
    public function put(UriInterface|string $uri, array $data = []): ResponseInterface
    {
        return $this->request('PUT', $uri, $data);
    }

    /**
     * Делает запрос на переданный uri
     *
     * @param string $method
     * @param string $uri
     * @param array $data
     * @return ResponseInterface
     * @throws BadResponseException
     */
    protected function request(string $method, string $uri, array $data = []): ResponseInterface
    {
        try {
            $options = $data
                ? [
                    'body' => $this->encodePayload($data)
                ]
                : [];
            return $this->client->request($method, $uri, $options);

        } catch (BadResponseException $e) {
            $this->logger->error("Ошибка запроса {$e->getCode()} - {$e->getMessage()}");

            throw $e;

        } catch (\InvalidArgumentException $e) {
            $this->logger->error($e->getMessage());

            throw $e;
        }
    }

    /**
     * Кодирует данные в json-объект
     *
     * @param array $data
     * @return string
     * @throws \InvalidArgumentException
     */
    protected function encodePayload(array $data): string
    {
        $encoded = json_encode($data, JSON_UNESCAPED_UNICODE);

        if (false === $encoded) {
            throw new \InvalidArgumentException('Ошибка при кодировке данных запроса.');
        }

        return $encoded;
    }
}