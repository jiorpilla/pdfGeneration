<?php

namespace App\Service;

use App\Entity\Gallery;
use Doctrine\ORM\EntityManager;
use Dompdf\Dompdf;
use Dompdf\Options;
use Twig\Environment;

class GalleryPdfGenerator
{

    private $kernelProjectDir;
    private $entityManager;
    private $twig;

    public function __construct(string $kernelProjectDir, EntityManager $entityManager, Environment $twig)
    {
        $this->kernelProjectDir = $kernelProjectDir;
        $this->entityManager = $entityManager;
        $this->twig = $twig;
    }

    public function generatePDF(int $galleryId):void
    {
        //fetch the related gallery
        $gallery = $this->entityManager->getRepository(Gallery::class)->find($galleryId);

        //get the string rendition of the html
        $html = $this->renderView('pdf/index.html.twig', [
            'gallery' => $gallery,
            'imageSrcList' => $this->imagesToBase64($gallery->getImages()),
        ]);

        //set options for Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('paperSize', 'A4');
        $options->set('paperOrientation', 'portrait');
        $options->set('isRemoteEnabled', true);;

        //create new Dompdf object
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->render();

        $output = $dompdf->output();
        $pdfDirectory = $this->kernelProjectDir . '/public/pdf';
        $filename = $galleryId;

        // Check if the directory exists, create it if not
        if (!is_dir($pdfDirectory)) {
            mkdir($pdfDirectory, 0775, true);
        }

        $pdfFilePath = $pdfDirectory . '/' . $filename . '.pdf';

        file_put_contents($pdfFilePath, $output);
    }

    /**
     * this will render the view using twig.
     * @param string $view
     * @param array $parameters
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    private function renderView(string $view, array $parameters = []): string
    {
        // Render the view using Twig
        return $this->twig->render($view, $parameters);
    }

    /**
     * this will help on how images will be shown on the pdf file
     * @param $images
     * @return array
     */
    private function imagesToBase64($images)
    {
        foreach ($images as $image) {
            $path = $image->getImageName();
            $images_path = $this->kernelProjectDir . '/public/images/';
            $type = pathinfo($images_path . $path, PATHINFO_EXTENSION);
            $data = file_get_contents($images_path . $path);
            $base64[] = 'data:image/' . $type . ';base64,' . base64_encode($data);
        }
        return $base64;
    }

}