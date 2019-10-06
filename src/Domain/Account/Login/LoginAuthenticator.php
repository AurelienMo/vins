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

namespace App\Domain\Account\Login;

use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;

/**
 * Class LoginAuthenticator
 */
class LoginAuthenticator extends AbstractFormLoginAuthenticator
{
    /** @var Resolver */
    protected $resolver;

    /** @var UserRepository */
    protected $userRepo;

    /** @var UrlGeneratorInterface */
    protected $urlGenerator;

    /**
     * LoginAuthenticator constructor.
     *
     * @param Resolver              $resolver
     * @param UserRepository        $userRepo
     * @param UrlGeneratorInterface $urlGenerator
     */
    public function __construct(
        Resolver $resolver,
        UserRepository $userRepo,
        UrlGeneratorInterface $urlGenerator
    ) {
        $this->resolver = $resolver;
        $this->userRepo = $userRepo;
        $this->urlGenerator = $urlGenerator;
    }

    public function supports(Request $request)
    {
        return $request->isMethod('POST') && $request->attributes->get('_route') === 'security_login';
    }

    public function getCredentials(Request $request)
    {
        $form = $this->resolver->getFormType();
        $form->handleRequest($request);

        return $form->getData();
    }

    public function getUser(
        $credentials,
        UserProviderInterface $userProvider
    ) {
        $user = $this->userRepo->loadUserByUsername($credentials->getIdentifier());

        if (is_null($user)) {
            throw new CustomUserMessageAuthenticationException('Identifiants invalides');
        }

        return $user;
    }

    public function checkCredentials(
        $credentials,
        UserInterface $user
    ) {
        $isValid = $this->resolver->validatePassword($user, $credentials->getPassword());

        if (!$isValid) {
            throw new CustomUserMessageAuthenticationException('Identifiants invalides');
        }

        return true;
    }

    public function onAuthenticationSuccess(
        Request $request,
        TokenInterface $token,
        $providerKey
    ) {
        return new RedirectResponse($this->urlGenerator->generate('easyadmin'));
    }

    protected function getLoginUrl()
    {
        return $this->urlGenerator->generate('security_login');
    }
}
