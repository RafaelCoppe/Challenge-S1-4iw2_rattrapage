<?php

namespace App\Controller;

use App\Repository\QuotationRepository;
use Dompdf\Dompdf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class PdfController extends AbstractController
{
    public function __construct(
        private HttpClientInterface $client,
        private QuotationRepository $quotationRepository,
    ) {
    }

    #[Route('/pdf/{id}/{facture}/{return_titre}', name: 'app_pdf')]
    public function index(int $id, int $facture, int $return_titre = 0): JsonResponse
    {
        $isFacture = ($facture == 1);
        $quote = $this->quotationRepository->find($id);
        $lines = [];
        $total = $totalHT = $totalTaxe = 0;
        $total_remise = 0;
        foreach (($quote->getLines())->toArray() as $uneLigne) {
            if($uneLigne->getProduct()->getCategory() == "remise"){
                $lines[] = [
                    "place" => $uneLigne->getPlace(),
                    "additional" => $uneLigne->getAdditional(),
                    "unit_price" => "",
                    "quantity" => "",
                    "tax" => "",
                    "totalHt" => "",
                    "totalTax" => "",
                    "product" => $uneLigne->getProduct()
                ];

                $total_remise += $uneLigne->getUnitPrice();
            }else{
                $unitPrice = $uneLigne->getUnitPrice();
                $quantity = $uneLigne->getQuantity();
                $tax = $uneLigne->getProduct()->getTax();

                $lines[] = [
                    "place" => $uneLigne->getPlace(),
                    "additional" => $uneLigne->getAdditional(),
                    "unit_price" => $unitPrice,
                    "quantity" => $quantity,
                    "tax" => $tax,
                    "totalHt" => $unitPrice * $quantity,
                    "totalTax" => ($unitPrice * $quantity) * (100 + $tax)/100,
                    "product" => $uneLigne->getProduct()
                ];

                $totalHT += $unitPrice * $quantity;
                $totalTaxe += ($unitPrice * $quantity) * ($tax)/100;
                $total += ($unitPrice * $quantity) * (100 + $tax)/100;
            }
        };

        if($total_remise > 0){
            $total_with_remise = ($total - $total_remise);
        }

        $response = $this->client->request(
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

        $response = $this->client->request(
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
            'logoDevisio'   => $this->imageToBase64('images/logoDevisio.png'),
            'quote'          => $quote,
            'lines'          => $lines,
            'total'          => $total,
            'totalHT'        => $totalHT,
            'totalTaxe'      => $totalTaxe,
            'client'         => $quoteClient,
            'agency'         => $quoteAgency,
            'isFacture'      => $isFacture,
            'planeImage'     => $this->imageToBase64('images/plane.png'),
            'dev'            => getenv('APP_ENV') == 'dev'
        ];

        if(isset($total_with_remise)){
            $data['total_with_remise'] = round($total_with_remise, 2);
        }

        if($isFacture){
            $invoice = $quote->getInvoice();

            $response = $this->client->request(
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

        if($return_titre){
            return new JsonResponse($titre);
        }else{
            header("Content-type:application/pdf");
            header("Content-Disposition:attachment;filename=\"$titre\"");
            readfile($titre);
            unlink($titre);
        }
    }

    private function imageToBase64($path): string
    {
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        return 'data:image/' . $type . ';base64,' . base64_encode($data);
    }
}
