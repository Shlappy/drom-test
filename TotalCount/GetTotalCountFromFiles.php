<?php declare(strict_types=1);

/**
 * Проходится по всем директориям и возвращает сумму всех чисел из файла count (файлов count может быть много)
 *
 * @param string $directory
 * @return int
 */
function getTotalCountFromFiles(string $directory): int
{
    if (is_file($directory) && basename($directory) === 'count') {
        $number = trim(file_get_contents($directory));
        return is_numeric($number) ? (int)$number : 0;
    }

    $filenames = @scandir($directory);

    if (false === $filenames || count($filenames) <= 2) {
        return 0;
    }

    $sum = 0;
    foreach ($filenames as $filename) {
        if (in_array($filename, ['.', '..'], true)) {
            continue;
        }

        $sum += getTotalCountFromFiles(rtrim($directory, '/') . "/$filename");
    }

    return $sum;
}

echo getTotalCountFromFiles(__DIR__ . '/files/'), PHP_EOL;
