<?php

namespace App\Service;

use Symfony\Component\Filesystem\Filesystem;

class ImageHandler
{
    private Filesystem $filesystem;

    /**
     * ImageHandler constructor.
     */
    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    public function save(string $newThumbnailImage, string $originalThumbnailImage): void
    {
        //TODO: Kép mentése
        if (!$this->filesystem->exists('images/' . $newThumbnailImage)) {
            $this->addImageToImagesFolder($newThumbnailImage, $originalThumbnailImage);
        }
    }

    public function addImageToImagesFolder(string $newThumbnailImage, string $originalThumbnailImage)
    {
        file_put_contents('images/' . $newThumbnailImage, file_get_contents($originalThumbnailImage));
    }
}