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

namespace App\Responders;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class JsonResponder
 */
final class JsonResponder
{
    public function __invoke(?array $datas = null, int $statusCode = Response::HTTP_OK, array $addHeaders = [])
    {
        return new JsonResponse($datas, $statusCode, $addHeaders);
    }
}
