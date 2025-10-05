<?php
declare(strict_types=1);

namespace App\Service;

use Laminas\Diactoros\UploadedFile;

class UploadImageService
{
    /**
     * Upload a single image and resize it if needed.
     *
     * @param \Laminas\Diactoros\UploadedFile|array<string, mixed> $data Uploaded file array or instance
     */
    public function upload(array|UploadedFile $data, string $fieldName = 'image', string $targetFolder = 'products', ?int $maxWidth = null): ?string
    {
        $uploadedFile = null;

        if ($data instanceof UploadedFile) {
            $uploadedFile = $data;
        } elseif (isset($data[$fieldName]) && $data[$fieldName] instanceof UploadedFile) {
            $uploadedFile = $data[$fieldName];
        }

        if (!$uploadedFile || $uploadedFile->getError() !== UPLOAD_ERR_OK) {
            return null;
        }

        $originalName = $uploadedFile->getClientFilename() ?? 'unknown';
        $filename = \time() . '_' . \preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $originalName);

        $targetPath = WWW_ROOT . 'img' . DS . $targetFolder . DS;

        if (!\is_dir($targetPath)) {
            \mkdir($targetPath, 0755, true);
        }

        $filePath = $targetPath . $filename;
        $uploadedFile->moveTo($filePath);

        if ($maxWidth !== null) {
            $sizeInfo = @\getimagesize($filePath);

            if (!$sizeInfo) {
                return $filename;
            }

            [$width, $height, $type] = $sizeInfo;

            if ($width > $maxWidth) {
                $ratio = $maxWidth / $width;
                $newWidth = $maxWidth;
                $newHeight = (int) ($height * $ratio);

                $srcImage = match ($type) {
                    IMAGETYPE_JPEG => \imagecreatefromjpeg($filePath),
                    IMAGETYPE_PNG => \imagecreatefrompng($filePath),
                    IMAGETYPE_GIF => \imagecreatefromgif($filePath),
                    default => null,
                };

                if ($srcImage !== null) {
                    if ($newWidth < 1 || $newHeight < 1) {
                        return $filename; // nedá sa vytvoriť obrazok
                    }
                    $dstImage = \imagecreatetruecolor($newWidth, $newHeight);

                    if ($dstImage === false) {
                        return $filename;
                    }

                    if ($type === IMAGETYPE_PNG || $type === IMAGETYPE_GIF) {
                        $transparent = \imagecolorallocatealpha($dstImage, 0, 0, 0, 127);

                        if ($transparent !== false) {
                            \imagecolortransparent($dstImage, $transparent);
                        }
                        \imagealphablending($dstImage, false);
                        \imagesavealpha($dstImage, true);
                    }

                    if ($srcImage) {
                        \imagecopyresampled($dstImage, $srcImage, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
                    }

                    match ($type) {
                        IMAGETYPE_JPEG => \imagejpeg($dstImage, $filePath, 90),
                        IMAGETYPE_PNG => \imagepng($dstImage, $filePath),
                        IMAGETYPE_GIF => \imagegif($dstImage, $filePath),
                        default => null,
                    };

                    if ($srcImage) {
                        \imagedestroy($srcImage);
                    }
                    \imagedestroy($dstImage);
                }
            }
        }

        return $filename;
    }
}
