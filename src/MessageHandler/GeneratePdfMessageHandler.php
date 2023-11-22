<?php

namespace App\MessageHandler;

use App\Message\GeneratePdfMessage;
use App\Service\GalleryPdfGenerator;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class GeneratePdfMessageHandler{

    private $pdfGenerator;

    public function __construct(GalleryPdfGenerator $pdfGenerator)
    {
        $this->pdfGenerator = $pdfGenerator;
    }

    public function __invoke(GeneratePdfMessage $message)
    {
        $galleryId = $message->getGalleryId();

        // Call the service method to generate PDF
        $this->pdfGenerator->generatePDF($galleryId);
    }
}
