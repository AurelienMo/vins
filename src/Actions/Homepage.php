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

namespace App\Actions;

use App\Responders\ViewResponder;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class Homepage
 *
 * @Route("/", name="homepage")
 */
class Homepage
{
    public function __invoke(ViewResponder $responder)
    {
        return $responder('home/index.html.twig');
    }
}
