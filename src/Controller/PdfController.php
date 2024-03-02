<?php

namespace App\Controller;

use App\Repository\QuotationRepository;
use Dompdf\Dompdf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class PdfController extends AbstractController
{
    #[Route('/pdf/{id}/{facture}', name: 'app_pdf')]
    public function index(QuotationRepository $quotationRepository, HttpClientInterface $client, int $id, int $facture): void
    {
        $isFacture = ($facture == 1);
        $quote = $quotationRepository->find($id);
        $lines = [];
        $total = $totalHT = $totalTaxe = 0;
        foreach (($quote->getLines())->toArray() as $uneLigne) {
            $lines[] = [
                "place" => $uneLigne->getPlace(),
                "additional" => $uneLigne->getAdditional(),
                "unit_price" => $uneLigne->getUnitPrice(),
                "quantity" => $uneLigne->getQuantity(),
                "tax" => $uneLigne->getProduct()->getTax(),
                "totalHt" => $uneLigne->getUnitPrice() * $uneLigne->getQuantity(),
                "totalTax" => ($uneLigne->getUnitPrice() * $uneLigne->getQuantity()) * (100 + $uneLigne->getProduct()->getTax())/100,
                "product" => $uneLigne->getProduct()
            ];

            $total += $uneLigne->getUnitPrice() * $uneLigne->getQuantity();
            $totalHT += ($uneLigne->getUnitPrice() * $uneLigne->getQuantity()) * (100 + $uneLigne->getProduct()->getTax())/100;
            $totalTaxe += ($uneLigne->getUnitPrice() * $uneLigne->getQuantity()) * ($uneLigne->getProduct()->getTax())/100;
        };

        $response = $client->request(
            'GET',
            'https://geo.api.gouv.fr/communes/' . $quote->getClient()->getCity()
        );
        $response = $response->toArray();
        $clientCity = $response['codesPostaux'][0] . " " . $response['nom'];

        $quoteClient = [
            "name" => $quote->getClient()->getLastName() . " " . $quote->getClient()->getFirstName(),
            "phone" => $quote->getClient()->getPhone(),
            "mail" => $quote->getClient()->getEmail(),
            "address" => $quote->getClient()->getAddress() . " " . $clientCity,
        ];

        $response = $client->request(
            'GET',
            'https://geo.api.gouv.fr/communes/' . $quote->getAgency()->getCity()
        );
        $response = $response->toArray();
        $agencyCity = $response['codesPostaux'][0] . " " . $response['nom'];

        $quoteAgency = [
            "name" => $quote->getAgency()->getName(),
            "phone" => $quote->getAgency()->getPhone(),
            "mail" => $quote->getAgency()->getMail(),
            "address" => $quote->getAgency()->getAddress() . " " . $agencyCity,
        ];

        $data = [
            'logoDevisio'   => $this->imageToBase64($this->getParameter('kernel.project_dir') . '/public/images/logoDevisio.png'),
            'quote'          => $quote,
            'lines'          => $lines,
            'total'          => $total,
            'totalHT'        => $totalHT,
            'totalTaxe'      => $totalTaxe,
            'client'         => $quoteClient,
            'agency'         => $quoteAgency,
            'isFacture'      => $isFacture,
            'planeImage'     => $this->imageToBase64($this->getParameter('kernel.project_dir') . '/public/images/plane.png'),
            'dev'            => getenv('APP_ENV') == 'dev'
        ];

        if($isFacture){
            $invoice = $quote->getInvoice();

            $response = $client->request(
                'GET',
                'https://geo.api.gouv.fr/communes/' . $invoice->getPaymentCity()
            );
            $response = $response->toArray();
            $paymentCity = $response['codesPostaux'][0] . " " . $response['nom'];

            $payment = [
                "lastname" => $invoice->getPaymentLastname(),
                "firstname" => $invoice->getPaymentFirstname(),
                "mail" => $invoice->getPaymentEmail(),
                "phone" => $invoice->getPaymentPhone(),
                "address" => $invoice->getPaymentAddress() . " " . $paymentCity,
            ];
            $data['payment'] = $payment;

            $travelers = [];
            foreach ($quote->getInvoice()->getTravelers() as $traveler) {
                $travelers[] = [
                    "lastname" => $traveler->getLastname(),
                    "firstname" => $traveler->getFirstname(),
                    "age" => $traveler->getAge(),
                ];
            }
            $data['travelers'] = $travelers;
        }

        $html =  $this->renderView('pdf/pdf.html.twig', $data);
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->render();
        $dompdf->output();
        $titre = ($isFacture ? 'facture_' : 'devis_') . $quote->getRef() . '.pdf';
        file_put_contents($titre, $dompdf->output());

        header("Content-type:application/pdf");
        header("Content-Disposition:attachment;filename=\"$titre\"");
        readfile($titre);
        unlink($titre);
    }

    private function imageToBase64($path): string
    {
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        return 'data:image/' . $type . ';base64,' . base64_encode($data);
    }
}
