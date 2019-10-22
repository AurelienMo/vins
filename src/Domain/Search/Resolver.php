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

namespace App\Domain\Search;

use App\Domain\Search\Forms\SearchTextType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class Resolver
 */
final class Resolver
{
    /** @var FormFactoryInterface */
    protected $formFactory;

    /**
     * Resolver constructor.
     *
     * @param FormFactoryInterface $formFactory
     */
    public function __construct(
        FormFactoryInterface $formFactory
    ) {
        $this->formFactory = $formFactory;
    }

    public function getSearchType(): FormInterface
    {
        return $this->formFactory->create(SearchTextType::class);
    }
}
