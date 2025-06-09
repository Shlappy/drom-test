<?php declare(strict_types=1);

namespace CommentsClient\Utils\Logger;

class Logger implements LoggerInterface
{
    const ERROR = 'error';

    public function __construct(protected LoggerInterface $logger)
    { }

    /**
     * Логирует переданный текст с учётом уровня логирования
     *
     * @param string $message
     * @param string $level
     * @return void
     */
    public function log(string $message, string $level): void
    {
        $this->logger->{$level}($message);
    }

    /**
     * Логирование ошибки
     *
     * @param string $message
     * @return void
     */
    public function error(string $message): void
    {
        $this->log($message, __FUNCTION__);
    }
}