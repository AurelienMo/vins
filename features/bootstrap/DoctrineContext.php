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

use App\Entity\AbstractEntity;
use App\Entity\Account;
use App\Entity\Article;
use App\Entity\CfgBank;
use App\Entity\User;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\ORM\Tools\ToolsException;
use Nelmio\Alice\Loader\NativeLoader;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;


/**
 * Class DoctrineContext
 */
class DoctrineContext implements Context
{
    /** @var SchemaTool */
    protected $schemaTool;

    /** @var RegistryInterface */
    protected $doctrine;

    /** @var KernelInterface */
    protected $kernel;

    /** @var EncoderFactoryInterface|EncoderFactory */
    protected $encoderFactory;

    /**
     * DoctrineContext constructor.
     *
     * @param RegistryInterface       $doctrine
     * @param KernelInterface         $kernel
     * @param EncoderFactoryInterface $encoderFactory
     */
    public function __construct(
        RegistryInterface $doctrine,
        KernelInterface $kernel,
        EncoderFactoryInterface $encoderFactory
    ) {
        $this->doctrine = $doctrine;
        $this->schemaTool = new SchemaTool($this->doctrine->getManager());
        $this->kernel = $kernel;
        $this->encoderFactory = $encoderFactory;
    }

    /**
     * @BeforeScenario
     *
     * @throws ToolsException
     */
    public function clearDatabase()
    {
        $this->schemaTool->dropSchema($this->doctrine->getManager()->getMetadataFactory()->getAllMetadata());
        $this->schemaTool->createSchema($this->doctrine->getManager()->getMetadataFactory()->getAllMetadata());
    }

    /**
     * @return ObjectManager
     */
    public function getManager()
    {
        return $this->doctrine->getManager();
    }

    /**
     * @Then the following entity :arg1 should have :arg2 entry into database
     *
     * @param string $entity
     * @param        $number
     *
     * @throws Exception
     */
    public function theFollowingEntityShouldHaveEntryIntoDatabase(string $entity, $number)
    {
        $totalEntries = $this->getManager()->getRepository($entity)->findAll();

        if (count($totalEntries) !== (int) $number) {
            throw new Exception(
                sprintf("'%s' entry expected, '%s' found", $number, count($totalEntries))
            );
        }
    }

    /**
     * @Given I load following file :arg1
     *
     * @param string $file
     */
    public function iLoadFollowingFile(string $file)
    {
        $loader = new NativeLoader();
        $objectSet = $loader->loadFile(__DIR__.'/../fixtures/'.$file);

        foreach ($objectSet->getObjects() as $object) {
            if ($object instanceof User) {
                $encoder = $this->encoderFactory->getEncoder(User::class);
                $user = new User(
                    $object->getUsername(),
                    $object->getEmail(),
                    $encoder->encodePassword($object->getPassword(), '')
                );

                $this->getManager()->persist($user);
            } else {
                $this->getManager()->persist($object);
            }
        }

        $this->getManager()->flush();
    }

    /**
     * @param AbstractEntity $entity
     * @param string         $uuid
     *
     * @throws ReflectionException
     */
    private function setUuid(AbstractEntity $entity, string $uuid)
    {
        $reflection = new \ReflectionClass($entity);
        $property = $reflection->getProperty('id');
        $property->setAccessible(true);
        $property->setValue($entity, $uuid);
    }

    /**
     * @Given object :classname with property :property as value :value should have following id :targetId
     */
    public function objectWithPropertyAsValueShouldHaveFollowingId($classname, $property, $value, $targetId)
    {
        /** @var AbstractEntity $entity */
        $entity = $this->getManager()->getRepository($classname)
            ->findOneBy(
                [
                    $property => $value
                ]
            );
        $this->setUuid($entity, $targetId);
        $this->getManager()->flush();
    }

    /**
     * @Then object on entity :arg1 with property :arg2 and value :arg3 should be exist
     */
    public function objectOnEntityWithPropertyAndValueShouldBeExist($arg1, $arg2, $arg3)
    {
        $entity = $this->doctrine->getRepository($arg1)
            ->findOneBy(
                [
                    $arg2 => $arg3,
                ]
            );

        if (is_null($entity)) {
            throw new Exception('Object should be exist');
        }
    }
}
