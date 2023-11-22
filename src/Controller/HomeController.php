<?php

namespace App\Controller;

use App\Service\GalleryPdfGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
        ]);
    }

    /**
     * this was just created to test the GalleryPdfGenerator service
     * @param GalleryPdfGenerator $pdfGenerator
     * @return Response
     */
    #[Route('/generate_pdf', name: 'app_pdf_generator')]
    public function pdf_generator(GalleryPdfGenerator $pdfGenerator): Response
    {

        $pdfGenerator->generatePdf(7);

        // You can return a response or redirect as needed
        return new Response('PDF generated and saved');
    }
}

