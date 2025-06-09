<?php declare(strict_types=1);

namespace CommentsClient;

use CommentsClient\Exceptions\EmptyCommentUpdateDataException;
use CommentsClient\Http\HttpClientInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Клиент для сервиса комментариев
 */
class Client
{
    public function __construct(private HttpClientInterface $httpClient,)
    { }

    /**
     * Возвращает список комментариев
     *
     * @return array|null
     */
    public function get(): ?array
    {
        $response = $this->httpClient->get('comments');
        return $this->getBody($response);
    }

    /**
     * Добавляет комментарий
     *
     * @param string $name
     * @param string $text
     * @return array|null
     */
    public function create(string $name, string $text): ?array
    {
        $response = $this->httpClient->post('comments', [
            'name' => $name,
            'text' => $text
        ]);
        return $this->getBody($response);
    }

    /**
     * Обновляет переданные поля комментария
     *
     * @param int $id
     * @param string|null $name
     * @param string|null $text
     * @return array|null
     * @throws EmptyCommentUpdateDataException
     */
    public function update(int $id, ?string $name = null, ?string $text = null): ?array
    {
        if (! $name && ! $text) {
            throw new EmptyCommentUpdateDataException;
        }

        $data = [];
        if ($name) $data['name'] = $name;
        if ($text) $data['text'] = $text;

        $response = $this->httpClient->put("comments/$id", $data);
        return $this->getBody($response);
    }

    /**
     * Возвращает тело ответа
     *
     * @param ResponseInterface $response
     * @return array|null
     */
    protected function getBody(ResponseInterface $response): ?array
    {
        return json_decode($response->getBody()->getContents(), true);
    }
}