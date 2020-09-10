<?php declare(strict_types=1);

namespace App\Infrastructure\Common\Response;

use App\Domain\Common\View\ViewModelInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class ObjectModifiedResponse extends JsonResponse
{
    protected const STATUS_CREATED  = 'created';
    protected const STATUS_MODIFIED = 'altered';

    public static function createFromView(ViewModelInterface $view, string $status, int $httpCode)
    {
        return new static(
            [
                'status' => $status,
                'object' => $view,
                'type'   => static::formatAsType($view)
            ],
            $httpCode
        );
    }

    private static function formatAsType(ViewModelInterface $view): string
    {
        $replacements = [
            ['\\\\', '\\'],
            ['\\', '.'],
            ['App.Domain.', ''],
            ['.View.', '.']
        ];

        $str = get_class($view);

        foreach ($replacements as $replacement) {
            $str = str_replace($replacement[0], $replacement[1], $str);
        }

        return $str;
    }
}
