<?php declare(strict_types=1);

namespace CommentsClient\Exceptions;

class EmptyCommentUpdateDataException extends \Exception
{
    public function __construct(
        string $message = 'Одно из полей обязательно к заполнению при обновлении комментария.',
        int $code = 0,
        ?\Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}