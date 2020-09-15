<?php declare(strict_types=1);

namespace App\Domain\Common\Provider;

class MimeTypeListProvider
{
    /**
     * @var string[]
     */
    private static array $mimes = [];

    public static function getMimeTypes(): array
    {
        if (!static::$mimes) {
            static::loadMimes();
        }

        return static::$mimes;
    }

    private static function getMimeListPath(): string
    {
        if ($_ENV['MIMES_PATH'] ?? '') {
            return $_ENV['MIMES_PATH'];
        }

        return __DIR__ . '/../../../../config/mime.types';
    }

    private static function loadMimes(): void
    {
        $content = file_get_contents(static::getMimeListPath());
        $content = str_replace("\t", " ", $content);
        $asLines = explode("\n", $content);

        foreach ($asLines as $line) {
            if (strpos($line, '#') === 0) {
                continue;
            }

            static::$mimes[] = explode(' ', $line)[0];
        }
    }
}
