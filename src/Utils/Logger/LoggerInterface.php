<?php declare(strict_types=1);

namespace CommentsClient\Utils\Logger;

interface LoggerInterface
{
    public function log(string $message, string $level);

    public function error(string $message): void;
}