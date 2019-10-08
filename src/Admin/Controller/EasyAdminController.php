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

namespace App\Admin\Controller;

use AlterPHP\EasyAdminExtensionBundle\Controller\EasyAdminController as AdminController;
use App\Entity\Interfaces\Sluggable;
use App\Entity\Interfaces\UpdatableInterface;
use DateTime;
use ReflectionClass;
use Symfony\Component\PropertyAccess\PropertyAccessor;

/**
 * Class EasyAdminController
 */
class EasyAdminController extends AdminController
{
    public function persistEntity($entity)
    {
        $reflectClass = new ReflectionClass($entity);
        $propertyAccessor = new PropertyAccessor();
        if ($entity instanceof Sluggable) {
            foreach ($reflectClass->getProperties() as $prop) {
                switch ($prop->getName()) {
                    case 'name':
                        $entity->setSlug($propertyAccessor->getValue($entity, 'name'));
                        break;
                }
            }
        }

        parent::persistEntity($entity);
    }

    public function updateEntity($entity)
    {
        if ($entity instanceof Sluggable) {
            $reflectClass = new ReflectionClass($entity);
            $propertyAccessor = new PropertyAccessor();
            foreach ($reflectClass->getProperties() as $prop) {
                switch ($prop->getName()) {
                    case 'name':
                        $entity->setSlug($propertyAccessor->getValue($entity, 'name'));
                        break;
                }
            }
        }
        if ($entity instanceof UpdatableInterface) {
            $entity->setUpdatedAt(new DateTime());
        }

        parent::updateEntity($entity);
    }
}
