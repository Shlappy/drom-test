<?php declare(strict_types=1);

namespace CommentsClient\Utils\Logger;

class FileLogger implements LoggerInterface
{
    public function __construct(
        protected string $filename = 'log.txt',
        // В реальном клиенте будет вынесено в конфиг
        protected string $path = __DIR__ . '/../../../storage/logs/',
    ) {
    }

    public function log(string $message, string $level): void
    {
        $this->writeLog($message);
    }

    /**
     * Простая реализация логирования ошибки в файл без учёта всех потенциальных проблем
     *
     * @param string $message
     * @return void
     */
    public function error(string $message): void
    {
        $this->writeLog("[ERROR]: $message");
    }

    /**
     * Простая реализация логирования в файл без учёта всех потенциальных проблем
     *
     * @param string $message
     * @return void
     */
    protected function writeLog(string $message): void
    {
        $dir = @scandir($this->path);

        if (false === $dir) {
            mkdir($this->path, 0777, true);
        }

        file_put_contents($this->path . $this->filename, $message . PHP_EOL);
    }
}