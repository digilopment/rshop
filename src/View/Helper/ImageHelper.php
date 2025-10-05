<?php
declare(strict_types=1);

namespace App\View\Helper;

use Cake\View\Helper;

class ImageHelper extends Helper
{
    /**
     * @var array<string,string>
     */
    protected array $paths = [
        'eshopProduct' => '/img/products/',
        'default' => '/img/default/'
    ];

    public function product(?string $filename, string $type = 'default'): string
    {
        if (empty($filename)) {
            return $this->getView()->Url->build('/img/default/no-image.jpg');
        }

        if (\preg_match('#^https?://#i', $filename)) {
            return $filename;
        }

        $basePath = $this->paths[$type] ?? $this->paths['default'];

        $fullPath = WWW_ROOT . \ltrim($basePath, '/') . $filename;

        if (!\file_exists($fullPath)) {
            return $this->getView()->Url->build('/img/default/no-image.png');
        }

        return $this->getView()->Url->build($basePath . $filename);
    }
}
