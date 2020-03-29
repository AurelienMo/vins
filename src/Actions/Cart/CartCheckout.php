<?php

declare(strict_types=1);

namespace App\Actions\Cart;

use App\Domain\Cart\Delivery\Forms\DeliveryDTO;
use App\Domain\Cart\Delivery\Forms\DeliveryType;
use App\Domain\Cart\Helpers\StripeHelper;
use App\Domain\Cart\ValueObject\CartVO;
use App\Domain\Cart\ValueObject\ProductVO;
use App\Domain\Common\Constants\FlashMessage;
use App\Domain\Common\Helpers\BillGenerator;
use App\Domain\Common\Subscribers\Events\FlashMessageEvent;
use App\Domain\Order\Mails\Events\ConfirmMailEvent;
use App\Entity\Customer;
use App\Entity\Delivery;
use App\Entity\NicheOfDelivery;
use App\Entity\Order;
use App\Entity\WineDomain;
use App\Repository\OrderRepository;
use App\Responders\JsonResponder;
use App\Responders\RedirectResponder;
use App\Responders\ViewResponder;
use Doctrine\ORM\EntityManagerInterface;
use Konekt\PdfInvoice\InvoicePrinter;
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

    public function __construct(
        SessionInterface $session,
        EntityManagerInterface $entityManager,
        FormFactoryInterface $formFactory,
        StripeHelper $stripeHelper,
        OrderRepository $orderRepository,
        Environment $templating,
        EventDispatcherInterface $eventDispatcher,
        BillGenerator $billGenerator
    ) {
        $this->session = $session;
        $this->entityManager = $entityManager;
        $this->formFactory = $formFactory;
        $this->stripeHelper = $stripeHelper;
        $this->orderRepository = $orderRepository;
        $this->templating = $templating;
        $this->eventDispatcher = $eventDispatcher;
        $this->billGenerator = $billGenerator;
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
                $stripeVo = $this->stripeHelper->createChargeAndPayment($request->request->all());
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
}
