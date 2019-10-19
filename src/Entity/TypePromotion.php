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

namespace App\Entity;

use App\Entity\AdminMutators\TypePromotionTrait;
use App\Entity\Traits\NameTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class TypePromotion
 *
 * @ORM\Table(name="amo_type_promotion")
 * @ORM\Entity(repositoryClass="App\Repository\TypePromotionRepository")
 */
class TypePromotion extends AbstractEntity
{
    use NameTrait;
    use TypePromotionTrait;

    const TYPE_PERCENT = 'Pourcentage';
    const TYPE_AMOUNT = 'Montant';

    /**
     * @var string|null
     *
     * @ORM\Column(type="string")
     */
    protected $label;

    /**
     * @return string|null
     */
    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function __toString()
    {
        return $this->name;
    }
}
