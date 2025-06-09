<?php declare(strict_types=1);

namespace CommentsClient\Tests\Unit;

use CommentsClient\Utils\Logger\FileLogger;
use CommentsClient\Utils\Logger\Logger;
use PHPUnit\Framework\TestCase;

class FileLoggerTest extends TestCase
{
    private string $logDir;
    private string $logFile;
    private string $logFileName;

    protected function setUp(): void
    {
        parent::setUp();

        $this->logDir  = __DIR__ . '/../../storage/logs/';
        $this->logFileName = 'testing-log.txt';
        $this->logFile = $this->logDir . $this->logFileName;

        // Очистим до старта
        if (file_exists($this->logFile)) {
            unlink($this->logFile);
        }
    }

    protected function tearDown(): void
    {
        // Убираем после
        if (file_exists($this->logFile)) {
            unlink($this->logFile);
        }

        parent::tearDown();
    }

    /**
     * Тест: FileLogger::log() вызывает правильный метод для логирования
     *
     * @return void
     */
    public function testLogWritesSimpleMessage(): void
    {
        $fileLogger = new FileLogger($this->logFileName, $this->logDir);
        $message = 'Тестовое сообщение';
        $level = Logger::ERROR;

        $fileLogger->log($message, $level);

        $this->assertFileExists($this->logFile, 'Лог‑файл должен быть создан');
        $contents = file_get_contents($this->logFile);
        $this->assertStringContainsString($message, $contents, 'Сообщение должно быть записано в файл');
    }

    /**
     * Тест: FileLogger::error() правильно записывает текст ощибки в файл
     *
     * @return void
     */
    public function testErrorWritesPrefixedError(): void
    {
        $fileLogger = new FileLogger($this->logFileName, $this->logDir);
        $message = 'Ошибка';

        $fileLogger->error($message);

        $this->assertFileExists($this->logFile);
        $contents = file_get_contents($this->logFile);
        $this->assertStringContainsString(
            '[ERROR]: ' . $message,
            $contents,
            'В файле должна появиться строка с префиксом [ERROR]:'
        );
    }
}