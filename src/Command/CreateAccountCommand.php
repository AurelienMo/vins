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

namespace App\Command;

use App\Domain\User\Create\NewUserDTO;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

/**
 * Class CreateAccountCommand
 */
class CreateAccountCommand extends Command
{
    public const LIST_REQUIRED_FIELDS = [
        'firstname' => null,
        'lastname' => null,
        'email' => null,
        'password' => null,
        'role' => null,
    ];

    /** @var UserRepository */
    protected $userRepo;

    /** @var EncoderFactoryInterface */
    protected $encoderFactory;

    /**
     * CreateAccountCommand constructor.
     *
     * @param UserRepository          $userRepo
     * @param EncoderFactoryInterface $encoderFactory
     */
    public function __construct(
        UserRepository $userRepo,
        EncoderFactoryInterface $encoderFactory
    ) {
        $this->userRepo = $userRepo;
        $this->encoderFactory = $encoderFactory;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('app:create-account')
            ->setDescription('Allow person to create an account from CLI');
    }

    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ) {
        $fields = self::LIST_REQUIRED_FIELDS;
        $question = null;
        foreach ($fields as $property => $value) {
            if ($property !== 'role') {
                $question = new Question(
                    sprintf("Please choose a value for field '%s' : ", $property)
                );
            } else {
                $question = new ChoiceQuestion(
                    "Please choose a role",
                    [
                        'ROLE_USER',
                        'ROLE_ADMIN',
                    ]
                );
            }
            $fields[$property] = $this->getQuestionHelper()->ask($input, $output, $question);
        }

        $user = User::create(
            new NewUserDTO(
                $fields['firstname'],
                $fields['lastname'],
                $fields['email'],
                ($this->encoderFactory->getEncoder(User::class))->encodePassword($fields['password'], ''),
                $fields['role']
            )
        );

        $this->userRepo->persist($user);
        $this->userRepo->flush();
    }

    private function getQuestionHelper(): QuestionHelper
    {
        return $this->getHelper('question');
    }
}
