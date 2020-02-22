<?php

declare(strict_types=1);

namespace App\Responders;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class RedirectResponder
{
    /** @var UrlGeneratorInterface */
    protected $urlGenerator;

    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    public function __invoke(string $routeName, array $params = [])
    {
        return new RedirectResponse($this->urlGenerator->generate($routeName, $params));
    }
}
