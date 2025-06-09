<?php declare(strict_types=1);

namespace CommentsClient\Utils\Logger;

class FileLogger implements LoggerInterface
{
    // В реальном клиенте будет вынесено в конфиги
    const PATH = __DIR__ . '/../../../storage/logs/';

    const FILENAME = 'log.txt';

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
        $dir = @scandir(self::PATH);

        if (false === $dir) {
            mkdir(self::PATH, 0777, true);
        }

        file_put_contents(self::PATH . self::FILENAME, $message . PHP_EOL);
    }
}