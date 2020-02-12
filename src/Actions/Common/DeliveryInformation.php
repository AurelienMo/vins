<?php

declare(strict_types=1);

namespace App\Actions\Common;

use App\Responders\ViewResponder;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/information-livraison", name="delivery_information")
 */
class DeliveryInformation
{
    public function __invoke(ViewResponder $responder): Response
    {
        return $responder('static/delivery_information.html.twig');
    }
}
