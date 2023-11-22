<?php

namespace App\Message;

final class GeneratePdfMessage
{
     private $gallery_id;

     public function __construct(int $gallery_id)
     {
         $this->gallery_id = $gallery_id;
     }

    public function getGalleryId(): string
    {
        return $this->gallery_id;
    }
}
