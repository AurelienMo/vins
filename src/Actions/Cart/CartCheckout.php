<?php

declare(strict_types=1);

namespace App\Actions\Cart;

use App\Domain\Cart\Delivery\Forms\DeliveryDTO;
use App\Domain\Cart\Delivery\Forms\DeliveryType;
use App\Domain\Cart\Helpers\StripeHelper;
use App\Domain\Cart\ValueObject\BoxVO;
use App\Domain\Cart\ValueObject\CartVO;
use App\Domain\Cart\ValueObject\ProductVO;
use App\Domain\Common\Constants\FlashMessage;
use App\Domain\Common\Helpers\BillGenerator;
use App\Domain\Common\Subscribers\Events\FlashMessageEvent;
use App\Domain\Order\Mails\Events\ConfirmMailEvent;
use App\Entity\BoxWine;
use App\Entity\Capacity;
use App\Entity\Customer;
use App\Entity\Delivery;
use App\Entity\NicheOfDelivery;
use App\Entity\Order;
use App\Entity\StockEntry;
use App\Entity\WineDomain;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use App\Repository\StockRepository;
use App\Responders\JsonResponder;
use App\Responders\RedirectResponder;
use App\Responders\ViewResponder;
use Doctrine\ORM\EntityManagerInterface;
use Konekt\PdfInvoice\InvoicePrinter;
use Stripe\Exception\CardException;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
use Twig\Environment;

/**
 * @Route("/mon-panier", name="cart_checkout")
 */
class CartCheckout
{
    /** @var SessionInterface */
    protected $session;

    /** @var EntityManagerInterface */
    protected $entityManager;

    /** @var FormFactoryInterface */
    protected $formFactory;

    /** @var StripeHelper */
    protected $stripeHelper;

    /** @var OrderRepository */
    protected $orderRepository;

    /** @var Environment */
    protected $templating;

    /** @var EventDispatcherInterface */
    protected $eventDispatcher;

    /** @var BillGenerator */
    protected $billGenerator;

    /** @var ProductRepository */
    protected $productRepository;

    /** @var StockRepository */
    protected $stockRepository;

    public function __construct(
        SessionInterface $session,
        EntityManagerInterface $entityManager,
        FormFactoryInterface $formFactory,
        StripeHelper $stripeHelper,
        OrderRepository $orderRepository,
        Environment $templating,
        EventDispatcherInterface $eventDispatcher,
        BillGenerator $billGenerator,
        ProductRepository $productRepository,
        StockRepository $stockRepository
    ) {
        $this->session = $session;
        $this->entityManager = $entityManager;
        $this->formFactory = $formFactory;
        $this->stripeHelper = $stripeHelper;
        $this->orderRepository = $orderRepository;
        $this->templating = $templating;
        $this->eventDispatcher = $eventDispatcher;
        $this->billGenerator = $billGenerator;
        $this->productRepository = $productRepository;
        $this->stockRepository = $stockRepository;
    }

    public function __invoke(
        Request $request,
        ViewResponder $responder,
        JsonResponder $jsonResponder,
        RedirectResponder $redirectResponder
    ) {
        /** @var CartVO|null $cart */
        $cart = $this->session->has('cart') ? $this->session->get('cart') : null;
        $form = $this->formFactory->create(
            DeliveryType::class,
            $cart instanceof CartVO ? $cart->getDeliveryInformation() : null
        )->handleRequest($request);
        if ($request->isMethod('POST')) {
            if ($request->request->has('stripeToken')) {
                $error = null;
                try {
                    $stripeVo = $this->stripeHelper->createChargeAndPayment($request->request->all());
                } catch (CardException $e) {
                    switch ($e->getDeclineCode()) {
                        case 'authentication_required':
                            $error = 'Une authentification 3D Secure est requise avec cette carte.';
                            break;
                    }
                    $this->eventDispatcher->dispatch(new FlashMessageEvent('error', $error));

                    return $redirectResponder($request->attributes->get('_route'), $request->attributes->get('_route_params'));
                }
                /** @var Order $order */
                $dateNow = new \DateTime();
                $customer = Customer::create($cart->getDeliveryInformation());
                $niche = null;
                if ($cart->getDeliveryInformation()->getDeliveryNiche() instanceof NicheOfDelivery) {
                    $niche = $this->entityManager->getRepository(NicheOfDelivery::class)
                                                 ->find($cart->getDeliveryInformation()->getDeliveryNiche()->getId());
                }
                $delivery = Delivery::createFromPayment($cart->getDeliveryInformation(), $niche);
                $this->entityManager->persist($customer);
                $this->entityManager->persist($delivery);
                $order = Order::createFromPayment(
                    $cart,
                    $stripeVo,
                    $customer,
                    $delivery
                );
                $ordersFind = $this->orderRepository->findLastBillNumberForOrderYear($dateNow);
                $order->setBillNumber(
                    count($ordersFind) === 0 ?
                        $dateNow->format('Y').'-1' :
                        $dateNow->format('Y').'-'.(count($ordersFind) + 1)
                );

                $this->entityManager->persist($order);
                $delivery->setOrder($order);
                $this->entityManager->flush();
                $this->createStockEntry($order, $cart->getBoxs());
                if ($this->session->has('cart')) {
                    $this->session->remove('cart');
                }
                $filePath = $this->billGenerator->generateBill($order);
                $this->eventDispatcher->dispatch(new ConfirmMailEvent($order, $filePath));
                $this->eventDispatcher->dispatch(new FlashMessageEvent('success', FlashMessage::SUCCESS_ORDER));

                return $redirectResponder('homepage');
            } else {
                $this->processingForm($request, $form);

                return $jsonResponder(
                    [
                        'html' => $this->templating->render(
                            'cart/payment_button.html.twig',
                            [
                                'cart' => $cart,
                            ]
                        )
                    ]
                );
            }
        } else {
            /** @var ProductVO $product */
            if ($cart instanceof CartVO) {
                foreach ($cart->getProducts() as $product) {
                    $domain = $this->entityManager->getRepository(WineDomain::class)->find($product->getDomain()->getId());
                    $product->setDomain($domain);
                }
            }
        }

        return $responder(
           'cart/checkout.html.twig',
            [
                'cart' => $cart,
                'form' => $form->createView(),
            ]
        );
    }

    private function processingForm(Request $request, FormInterface $form)
    {
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var CartVO $cart */
            $cart = $this->session->get('cart');
            /** @var DeliveryDTO $data */
            $data = $form->getData();
            if ($data->getTypeDelivery() === 'basic') {
                $data->setDeliveryNiche(null);
            }
            $cart->affectDelivery($data);
        }
    }

    private function createStockEntry(Order $order, array $boxVos)
    {
        foreach ($order->getLines() as $line) {
            if ($line->getBoxName()) {
                /** @var BoxWine $box */
                $box = current(array_filter($boxVos, function (BoxVO $boxVO) use ($line) {
                    return $boxVO->getBox()->getName() === $line->getBoxName();
                }))->getBox();
                /** @var Capacity $wine */
                foreach ($box->getWines() as $wine) {
                    $stock = $this->stockRepository->findOneBy(
                        [
                            'capacity' => $wine
                        ]
                    );
                    $stockEntry = StockEntry::create($stock, $line->getQuantity(), $order);
                    $this->entityManager->persist($stockEntry);
                    $stock->updateStockAfterUpdate($line->getQuantity(), StockEntry::TYPE_OUT);
                    $this->entityManager->flush();
                }
            } else {
                $stock = $this->stockRepository->findStockByParams(
                    $line->getYear(),
                    $line->getAppellation(),
                    $line->getVintageName(),
                    $line->getDomain(),
                    $line->getCapacityName(),
                    explode('L', $line->getLitrage())[0]
                );
                $stockEntry = StockEntry::create($stock, $line->getQuantity(), $order);
                $this->entityManager->persist($stockEntry);
                $stock->updateStockAfterUpdate($line->getQuantity(), StockEntry::TYPE_OUT);
                $this->entityManager->flush();
            }
        }
    }
}
