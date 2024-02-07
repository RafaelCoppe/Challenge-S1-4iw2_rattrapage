<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Snappy\Pdf;

class PdfController extends AbstractController
{
    #[Route('/pdf', name: 'app_pdf')]
    public function index(): Response
    {
        $knpSnappyPdf = new Pdf('/usr/local/bin/wkhtmltopdf ');
        $knpSnappyPdf->generateFromHtml(
            $this->renderView(
                'pdf/pdf.twig',
                [
                    //'imageSrc'     => $this->imageToBase64($this->getParameter('kernel.project_dir') . '/public/images/sound.png'),
                    'dev'          => getenv('APP_ENV') == 'dev'
                ]
            ),
            'TestPdf.pdf', [], true
        );

        /*$knpSnappyPdf->getOutput();*/

        return $this->render('default/index.html.twig', [
            'controller_name' => 'index',
        ]);
    }

    private function imageToBase64($path): string
    {
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        return 'data:image/' . $type . ';base64,' . base64_encode($data);
    }
}
