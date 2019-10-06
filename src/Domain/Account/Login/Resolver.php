<?php /** @noinspection ClassNameCollisionInspection */

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

use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Twig\Environment;

/**
 * Class Resolver
 */
final class Resolver
{
    /** @var FormFactoryInterface */
    protected $formFactory;

    /** @var AuthenticationUtils */
    protected $authUtils;

    /** @var Environment */
    protected $templating;

    /** @var UserPasswordEncoderInterface */
    protected $passwordEncoder;

    /**
     * Resolver constructor.
     *
     * @param FormFactoryInterface         $formFactory
     * @param AuthenticationUtils          $authUtils
     * @param Environment                  $templating
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(
        FormFactoryInterface $formFactory,
        AuthenticationUtils $authUtils,
        Environment $templating,
        UserPasswordEncoderInterface $passwordEncoder
    ) {
        $this->formFactory = $formFactory;
        $this->authUtils = $authUtils;
        $this->templating = $templating;
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @return FormInterface
     */
    public function getFormType(): FormInterface
    {
        return $this->formFactory->create(LoginType::class);
    }

    public function getTemplate(): string
    {
        return 'security/login.html.twig';
    }

    public function validatePassword(UserInterface $user, string $password): bool
    {
        return $this->passwordEncoder->isPasswordValid($user, $password);
    }
    /**
     * @return AuthenticationException|null
     */
    public function getLastAuthErrors(): ?AuthenticationException
    {
        return $this->authUtils->getLastAuthenticationError();
    }
}
