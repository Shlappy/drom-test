<?php

namespace CommentsClient;

require __DIR__.'/../vendor/autoload.php';

use CommentsClient\Http\GuzzleHttpClient;
use CommentsClient\Utils\Logger\FileLogger;
use CommentsClient\Utils\Logger\Logger;

$client = new Client(
    // В реальном приложении будет использован механизм DI
    new GuzzleHttpClient(
        // В реальном приложении будет использован механизм DI
        new Logger(new FileLogger(
            'log.txt',
            __DIR__ . '/../storage/logs/'
        )),
        'http://example.com/'
    )
);

// Создать комментарий
$responseData = $client->create('Василий', 'Текст комментария');

// Обновить комментарий
$responseData = $client->update(1, null, 'Обновлённый текст комментария');

// Список всех комментариев
$comments = $client->get();
