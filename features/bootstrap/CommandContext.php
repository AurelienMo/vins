<?php

declare(strict_types=1);

/*
 * This file is part of management
 *
 * (c) Aurelien Morvan <morvan.aurelien@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


use Behat\Symfony2Extension\Context\KernelAwareContext;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

/**
 * Class CommandContext
 */
class CommandContext implements KernelAwareContext
{
    /** @var KernelInterface */
    protected $kernel;

    /** @var Application */
    protected $application;

    /** @var Command */
    protected $command;

    /** @var CommandTester */
    protected $commandTester;

    /** @var string */
    protected $commandException;

    /** @var array */
    protected $options = [];

    /** @var EncoderFactoryInterface */
    protected $encoderFactory;

    /** @var EntityManagerInterface */
    protected $entityManager;

    /**
     * CommandContext constructor.
     *
     * @param EncoderFactoryInterface $encoderFactory
     * @param EntityManagerInterface  $entityManager
     */
    public function __construct(
        EncoderFactoryInterface $encoderFactory,
        EntityManagerInterface $entityManager
    ) {
        $this->encoderFactory = $encoderFactory;
        $this->entityManager = $entityManager;
    }

    public function setKernel(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     *
     */
    private function setApplication()
    {
        $this->application = new Application($this->kernel);
    }

    private function setCommand($commandName)
    {
        $this->command = $this->application->find($commandName);
    }

    private function getTester(Command $command)
    {
        $this->commandTester = new CommandTester($command);

        return $this->commandTester;
    }
}
