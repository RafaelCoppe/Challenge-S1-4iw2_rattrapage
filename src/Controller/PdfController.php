<?php

namespace App\Controller;

use App\Repository\QuotationRepository;
use Doctrine\ORM\EntityManager;
use Dompdf\Dompdf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PdfController extends AbstractController
{
    #[Route('/pdf/{id}', name: 'app_pdf')]
    public function index(QuotationRepository $quotationRepository, int $id): Response
    {
        $quote = $quotationRepository->find($id);
        $lines = [];
        $total = $totalHT = $totalTaxe = 0;
        foreach (($quote->getLines())->toArray() as $uneLigne) {
            $lines[] = [
                "place" => $uneLigne->getPlace(),
                "additional" => $uneLigne->getAdditional(),
                "unit_price" => $uneLigne->getUnitPrice(),
                "quantity" => $uneLigne->getQuantity(),
                "tax" => $uneLigne->getTax(),
                "totalHt" => $uneLigne->getUnitPrice() * $uneLigne->getQuantity(),
                "totalTax" => ($uneLigne->getUnitPrice() * $uneLigne->getQuantity()) * (100 + $uneLigne->getTax())/100,
                "product" => $uneLigne->getProduct()
            ];

            $total += $uneLigne->getUnitPrice() * $uneLigne->getQuantity();
            $totalHT += ($uneLigne->getUnitPrice() * $uneLigne->getQuantity()) * (100 + $uneLigne->getTax())/100;
            $totalTaxe += ($uneLigne->getUnitPrice() * $uneLigne->getQuantity()) * ($uneLigne->getTax())/100;
        };

        $data = [
            //'imageSrc'     => $this->imageToBase64($this->getParameter('kernel.project_dir') . '/public/images/sound.png'),
            'quote'          => $quote,
            'lines'          => $lines,
            'total'          => $total,
            'totalHT'        => $totalHT,
            'totalTaxe'      => $totalTaxe,
            'dev'          => getenv('APP_ENV') == 'dev'
        ];
        //dd($quote, $lines);
        $html =  $this->renderView('pdf/pdf.html.twig', $data);
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->render();
        $output = $dompdf->output();
        file_put_contents('TestPdf.pdf', $output);

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
