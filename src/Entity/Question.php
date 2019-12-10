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
 * Class Question
 *
 * @ORM\Table(name="amo_question")
 * @ORM\Entity()
 */
class Question extends AbstractEntity
{
    /**
     * @var Quizz
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Quizz", inversedBy="questions")
     * @ORM\JoinColumn(name="amo_quizz_id", referencedColumnName="id")
     */
    protected $quizz;

    /**
     * @var Answer[]|Collection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Answer", mappedBy="question", cascade={"persist", "remove"})
     */
    protected $answers;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     */
    protected $label;

    public function __construct()
    {
        $this->answers = new ArrayCollection();
        parent::__construct();
    }

    /**
     * @return Quizz
     */
    public function getQuizz(): Quizz
    {
        return $this->quizz;
    }

    /**
     * @param Quizz $quizz
     */
    public function setQuizz(Quizz $quizz): void
    {
        $this->quizz = $quizz;
    }

    /**
     * @return Answer[]|Collection
     */
    public function getAnswers()
    {
        return $this->answers;
    }

    public function addAnswer(Answer $answer)
    {
        $this->answers->add($answer);
        $answer->setQuestion($this);

        return $this;
    }

    public function removeAnswer(Answer $answer)
    {
        $this->answers->removeElement($answer);
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @param string $label
     */
    public function setLabel(string $label): void
    {
        $this->label = $label;
    }
}
