<?php declare(strict_types=1);

namespace CommentsClient\Tests\Unit;

use CommentsClient\Client;
use CommentsClient\Exceptions\EmptyCommentUpdateDataException;
use CommentsClient\Http\GuzzleHttpClient;
use CommentsClient\Utils\Logger\FileLogger;
use CommentsClient\Utils\Logger\Logger;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

class CommentsClientTest extends TestCase
{
    /**
     * Тест: получение комментариев работает
     *
     * @return void
     */
    public function testGetCommentsWorks(): void
    {
        $mockResponse = new Response(200, [], json_encode([
            ['id' => 1, 'name' => 'Игорь', 'text' => 'Привет'],
            ['id' => 2, 'name' => 'Олег', 'text' => 'Комментарий Олега']
        ]));

        $client = $this->createClientWithMock($mockResponse);
        $comments = $client->get();

        $this->assertCount(2, $comments);
        $this->assertEquals('Игорь', $comments[0]['name']);
    }

    /**
     * Тест: добавление новых комментариев работает
     *
     * @return void
     */
    public function testCreateCommentWorks(): void
    {
        $mockResponse = new Response(200, [], json_encode([
            'id' => 3, 'name' => 'Мария', 'text' => 'Комментарий Марии'
        ]));

        $client = $this->createClientWithMock($mockResponse);
        $comment = $client->create('Мария', 'Комментарий Марии');

        $this->assertEquals(3, $comment['id']);
        $this->assertEquals('Мария', $comment['name']);
    }

    /**
     * Тест: обновление комментариев работает
     *
     * @return void
     */
    public function testUpdateCommentWorks(): void
    {
        $mockResponse = new Response(200, [], json_encode([
            'id' => 3, 'name' => 'Мария', 'text' => 'Новый текст'
        ]));

        $client = $this->createClientWithMock($mockResponse);
        $updated = $client->update(3, null, 'Новый текст');

        $this->assertEquals('Новый текст', $updated['text']);
    }

    /**
     * Тест: обновление комментариев вызывает ошибку
     * если не переданы никакие данные для обновления
     *
     * @return void
     */
    public function testUpdateCommentThrowsErrorIfNoDataPassed(): void
    {
        $mockResponse = new Response(200, [], json_encode(['id' => 3]));

        $client = $this->createClientWithMock($mockResponse);

        $this->expectException(EmptyCommentUpdateDataException::class);

        $client->update(3);
    }

    /**
     * Тест: при ошибке 400 повторно выкидывается ошибка из клиента
     *
     * @return void
     */
    public function testCreateCommentThrowsClientExceptionOn400(): void
    {
        $mockResponse = new Response(400, [], json_encode(['error' => 'Invalid data']));
        $client = $this->createClientWithMock($mockResponse);

        $this->expectException(ClientException::class);

        $client->create('Олег', 'Текст комментария');
    }

    /**
     * Тест: при ошибке 500 повторно выкидывается ошибка из клиента
     *
     * @return void
     */
    public function testGetCommentsThrowsServerExceptionOn500()
    {
        $mockResponse = new Response(500, [], 'Internal error');
        $client = $this->createClientWithMock($mockResponse);

        $this->expectException(ServerException::class);

        $client->get();
    }

    /**
     * Создаёт клиент для сервиса комментариев с моком http-клиентом
     *
     * @param ResponseInterface $response
     * @return Client
     */
    private function createClientWithMock(ResponseInterface $response): Client
    {
        $mock = new MockHandler([$response]);
        $handlerStack = HandlerStack::create($mock);
        $guzzleClient = new GuzzleClient(['handler' => $handlerStack, 'base_uri' => 'http://example.com/']);
        $guzzleHttpClient = new GuzzleHttpClient(
        // В реальном приложении будет использован механизм DI
            new Logger(new FileLogger()),
            'http://example.com/',
            $guzzleClient
        );
        return new Client($guzzleHttpClient);
    }
}