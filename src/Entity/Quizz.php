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

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Quizz
 *
 * @ORM\Table(name="amo_quizz")
 * @ORM\Entity()
 */
class Quizz extends AbstractEntity
{
    /**
     * @var Product
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Product", inversedBy="quizzs")
     * @ORM\JoinColumn(name="amo_wine_id", referencedColumnName="id")
     */
    protected $wine;

    /**
     * @var Question[]|Collection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Question", mappedBy="quizz", cascade={"persist", "remove"})
     */
    protected $questions;

    public function __construct()
    {
        $this->questions = new ArrayCollection();
        parent::__construct();
    }

    /**
     * @return Product
     */
    public function getWine(): Product
    {
        return $this->wine;
    }

    /**
     * @param Product $wine
     */
    public function setWine(Product $wine): void
    {
        $this->wine = $wine;
    }

    /**
     * @return Question[]|Collection
     */
    public function getQuestions()
    {
        return $this->questions;
    }

    public function addQuestion(Question $question)
    {
        $this->questions->add($question);
        $question->setQuizz($this);

        return $this;
    }

    public function removeQuestion(Question $question)
    {
        $this->questions->removeElement($question);
    }
}
