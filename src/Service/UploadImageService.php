<?php

declare(strict_types=1);

namespace App\Service;

use Laminas\Diactoros\UploadedFile;

class UploadImageService
{
    /**
     * Upload a single image and resize it if needed
     *
     * @param array|UploadedFile $data Uploaded file array or instance
     * @param string $fieldName Field name in form data (default 'image')
     * @param string $targetFolder Folder inside webroot/img
     * @param int|null $maxWidth Maximum width of the image (optional)
     * @return string|null Returns filename on success, null on failure
     */
    public function upload($data, string $fieldName = 'image', string $targetFolder = 'products', ?int $maxWidth = null): ?string
    {
        $uploadedFile = null;

        if ($data instanceof UploadedFile) {
            $uploadedFile = $data;
        } elseif (is_array($data) && isset($data[$fieldName]) && $data[$fieldName] instanceof UploadedFile) {
            $uploadedFile = $data[$fieldName];
        }

        if (!$uploadedFile || $uploadedFile->getError() !== UPLOAD_ERR_OK) {
            return null;
        }

        $originalName = $uploadedFile->getClientFilename();
        $filename     = time() . '_' . preg_replace('/[^a-zA-Z0-9_\.-]/', '_', (string)$originalName);

        $targetPath = WWW_ROOT . 'img' . DS . $targetFolder . DS;
        if (!is_dir($targetPath)) {
            mkdir($targetPath, 0755, true);
        }

        $filePath = $targetPath . $filename;
        $uploadedFile->moveTo($filePath);

        // Resize if needed
        if ($maxWidth) {
            [$width, $height, $type] = getimagesize($filePath);
            if ($width > $maxWidth) {
                $ratio     = $maxWidth / $width;
                $newWidth  = $maxWidth;
                $newHeight = (int) ($height * $ratio);

                $srcImage = null;
                switch ($type) {
                    case IMAGETYPE_JPEG:
                        $srcImage = imagecreatefromjpeg($filePath);
                        break;
                    case IMAGETYPE_PNG:
                        $srcImage = imagecreatefrompng($filePath);
                        break;
                    case IMAGETYPE_GIF:
                        $srcImage = imagecreatefromgif($filePath);
                        break;
                }

                if ($srcImage) {
                    $dstImage = imagecreatetruecolor($newWidth, $newHeight);
                    if ($type == IMAGETYPE_PNG || $type == IMAGETYPE_GIF) {
                        imagecolortransparent($dstImage, imagecolorallocatealpha($dstImage, 0, 0, 0, 127));
                        imagealphablending($dstImage, false);
                        imagesavealpha($dstImage, true);
                    }

                    imagecopyresampled($dstImage, $srcImage, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

                    switch ($type) {
                        case IMAGETYPE_JPEG:
                            imagejpeg($dstImage, $filePath, 90);
                            break;
                        case IMAGETYPE_PNG:
                            imagepng($dstImage, $filePath);
                            break;
                        case IMAGETYPE_GIF:
                            imagegif($dstImage, $filePath);
                            break;
                    }

                    imagedestroy($srcImage);
                    imagedestroy($dstImage);
                }
            }
        }

        return $filename;
    }
}
