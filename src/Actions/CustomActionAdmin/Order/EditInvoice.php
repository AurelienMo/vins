<?php

declare(strict_types=1);

namespace App\Actions\CustomActionAdmin\Order;

use App\Domain\Common\Helpers\BillGenerator;
use App\Repository\OrderRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/order/edit-invoice", name="edit_invoice")
 */
class EditInvoice
{
    /** @var OrderRepository */
    protected $orderRepository;

    /** @var BillGenerator */
    protected $billGenerator;

    public function __construct(OrderRepository $orderRepository, BillGenerator $billGenerator)
    {
        $this->orderRepository = $orderRepository;
        $this->billGenerator = $billGenerator;
    }

    /**
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function __invoke(Request $request)
    {
        $idOrder = $request->query->get('id');
        $order = $this->orderRepository->find($idOrder);
        $this->billGenerator->generateBill($order, 'D');

        return new RedirectResponse($request->server->get('HTTP_REFERER'));
    }
}
