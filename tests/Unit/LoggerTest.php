<?php declare(strict_types=1);

namespace CommentsClient\Tests\Unit;

use CommentsClient\Utils\Logger\Logger;
use CommentsClient\Utils\Logger\LoggerInterface;
use PHPUnit\Framework\TestCase;

class LoggerTest extends TestCase
{
    /**
     * Тест: метод Logger::log() вызывает внутренний логгер с правильным уровнем
     *
     * @return void
     */
    public function testLogCallsUnderlyingLoggerWithCorrectLevel(): void
    {
        $message = 'Тестовое сообщение';
        $level = Logger::ERROR;

        // Мокаем внутренний логгер
        $inner = $this->createMock(LoggerInterface::class);
        $inner
            ->expects($this->once())
            ->method($level)
            ->with($this->equalTo($message));

        $logger = new Logger($inner);
        $logger->log($message, $level);
    }

    /**
     * Тест: метод Logger::error() вызывает внутренний логгер с правильным уровнем
     *
     * @return void
     */
    public function testErrorCallsUnderlyingErrorMethod(): void
    {
        $message = 'Ошибка';
        $level = Logger::ERROR;

        $inner = $this->createMock(LoggerInterface::class);
        $inner
            ->expects($this->once())
            ->method($level)
            ->with($this->equalTo($message));

        $logger = new Logger($inner);
        $logger->{$level}($message);
    }
}