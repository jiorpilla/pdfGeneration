<?php

namespace App\Controller;

use DateTime;
use Dompdf\Dompdf;
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

    #[Route('/generate_pdf', name: 'app_pdf_generator')]
    public function pdf_generator(): Response
    {
//        $data = [
//            'imageSrc' => $this->imageToBase64($this->getParameter('kernel.project_dir') . '/public/img/profile.png'),
//            'name' => 'John Doe',
//            'address' => 'USA',
//            'mobileNumber' => '000000000',
//            'email' => 'john.doe@email.com',
//        ];
        $html = $this->renderView('pdf/index.html.twig');
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->render();

        $output = $dompdf->output();
        $pdfDirectory = $this->getParameter('kernel.project_dir') . '/public/pdf';
        $filename = (new DateTime())->format("YmdHis");
        // Check if the directory exists, create it if not
        if (!is_dir($pdfDirectory)) {
            mkdir($pdfDirectory, 0755, true);
        }

        $pdfFilePath = $pdfDirectory . '/ ' . $filename . '.pdf';
        file_put_contents($pdfFilePath, $output);

        // You can return a response or redirect as needed
        return new Response('PDF generated and saved at: ' . $pdfFilePath);
    }

//    private function imageToBase64($path) {
//        $path = $path;
//        $type = pathinfo($path, PATHINFO_EXTENSION);
//        $data = file_get_contents($path);
//        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
//        return $base64;
//    }
}
