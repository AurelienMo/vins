<?php

declare(strict_types=1);

/*
 * This file is part of vins
 *
 * (c) Aurelien Morvan <morvan.aurelien@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Domain\Common\Helpers;

use App\Entity\Order;
use App\Entity\OrderProductLine;
use App\Repository\OrderRepository;
use Konekt\PdfInvoice\InvoicePrinter;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Class BillGenerator
 */
class BillGenerator
{
    /** @var OrderRepository */
    protected $orderRepo;

    /** @var string */
    protected $publicPath;

    /** @var string */
    protected $tmpBillFolder;

    public function __construct(OrderRepository $orderRepo, string $publicPath, string $tmpBillFolder)
    {
        $this->orderRepo = $orderRepo;
        $this->publicPath = $publicPath;
        $this->tmpBillFolder = $tmpBillFolder;
    }

    public function generateBillNumber(Order $order): string
    {
        $orders = $this->orderRepo->findAll();
        $resultsExploded = [];
        $billNumber = 1;
        if (count($orders) > 0) {
            foreach ($orders as $orderElt) {
                $resultsExploded[] = explode(
                    '_',
                    $orderElt->getBillNumber()
                )[3];
            }
            rsort($resultsExploded, SORT_NUMERIC);
            $current = current($resultsExploded);
            $current++;
            $billNumber = $current;
        }


        return sprintf(
            '%s_%s',
            $order->getOrderAt()->format('Y_m_d'),
            str_pad((string) $billNumber, 4, '0', STR_PAD_LEFT)
        );
    }

    public function generateBill(Order $order, string $mode = 'F')
    {
        $customer = $order->getCustomer();
        $delivery = $order->getDelivery();
        $lines = $order->getLines();
        $invoice = new InvoicePrinter('A4', '€', 'fr');
        $invoice->setLogo(sprintf('%s/%s', $this->publicPath, '/img/logo.png'));
        $invoice->setColor('#ff5046');
        $invoice->setType('Facture');
        $invoice->setReference($order->getBillNumber());
        $invoice->setDate($order->getOrderAt()->format('d/m/Y H:i'));
        $invoice->setFrom(
            [
                'Mon Premier Sommelier',
                '20 Rue de roux',
                '13004 Marseille',
                'France'
            ]
        );
        $city = sprintf('%s, %s', $customer->getZipCode(), $customer->getCity());
        $invoice->setTo(
            [
                $customer->getFullName(),
                $customer->getAddressCustomer(),
                $city,
                'France'
            ]
        );
        /** @var OrderProductLine $line */
        $subTotalHt = 0;
        $total = 0;
        foreach ($lines as $line) {
            $priceDisplay = !is_null($line->getPricePromo()) ?
                $line->getPricePromo() * $line->getQuantity() : $line->getUnitPrice() * $line->getQuantity();
            $invoice->addItem(
                $this->getLibelle($line),
                $this->getProductDescription($line),
                $line->getQuantity(),
                $line->getUnitPrice() - ($line->getUnitPrice() / 1.2),
                $line->getUnitPrice() / 1.2,
                is_null($line->getPricePromo()) ?
                    0 : ($line->getUnitPrice() - $line->getPricePromo()) * $line->getQuantity(),
                $priceDisplay
            );
            $total += $priceDisplay;
            $subTotalHt += ($priceDisplay * $line->getQuantity()) / 1.2;
        }
        $amountDelivery = $delivery->getPrice();
        $invoice->addTotal("Prix Total HT", $total / 1.2);
        $invoice->addTotal("TVA 20%", $total - ($total / 1.2));
        $invoice->addTotal("Livraison", $delivery->getPrice());
        $invoice->addTotal("Prix total TTC", $total + $amountDelivery);

        $invoice->addBadge(sprintf("Payée le %s", $order->getOrderAt()->format('d/m/Y')), '#269600');
        $invoice->addTitle('Informations de livraison');
        $invoice->addParagraph(sprintf('Vous avez choisi une livraison %s', $delivery->getContentText()));
        $invoice->addParagraph('Téléphone : ' . $customer->getPhoneNumber());
        if ($delivery->getCommentDelivery()) {
            $invoice->addParagraph('Commentaire : '.$delivery->getCommentDelivery());
        }
        if ($delivery->getPersonIfAbsent()) {
            $invoice->addParagraph("En cas d'absence : ".$delivery->getPersonIfAbsent());
        }
        $invoice->addTitle('Mentions légales');
        $invoice->addParagraph(
            "
Vous disposez d'un délai de rétractation de 14 jours selon l'article L121-21 du Code de la Consommation.<br/>
Mon Premier SASU, 20 rue de roux, 13004 Marseille.<br/>
878 400 548 R.C.S Marseille / TVA N°FR37 878400548 / SASU au capital de 10000€ / Code NAF n°47918
"
        );
        $out = sprintf('Commande_%s', $order->getOrderNumber());
        if ($mode === 'F') {
            $currentYear = (new \DateTime())->format('Y');
            $filesystem = new Filesystem();
            if(!$filesystem->exists($this->tmpBillFolder.$currentYear)) {
                $filesystem->mkdir($this->tmpBillFolder.$currentYear);
            }
            $out = $this->tmpBillFolder.$currentYear.'/'.$order->getOrderNumber().'.pdf';
        }
        $invoice->render($out, $mode);

        if ($mode === 'F') {
            return $out;
        }
    }

    private function getLibelle(OrderProductLine $line)
    {
        return !is_null($line->getBoxName()) ? $line->getBoxName() : sprintf('%s - %s', $line->getVintageName(), $line->getYear());
    }

    private function getProductDescription(OrderProductLine $line)
    {
        return is_null($line->getBoxName()) ?
            null :
            sprintf(
                "%s - %s<br/>%s %s",
                $line->getDomain(),
                $line->getAppellation(),
                $line->getCapacityName(),
                $line->getLitrage()
            );
    }
}
