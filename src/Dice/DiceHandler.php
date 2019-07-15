<?php

namespace Anjj16\Dice;

class DiceHandler extends Dice implements HistogramInterface
{
    use HistogramTrait2;


    private $p1Score;
    private $p2Score;
    private $computerHand;

    public function __construct()
    {
        $this->p1Score = 0;
        $this->p2Score = 0;
        $this->computerHand = new DiceHand();
    }

    public function p1save($sum)
    {
        $this->p1Score += $sum;
    }

    public function resetSerie()
    {
        $this->serie = [];
    }
    public function resetValues()
    {
        $this->computerHand->resetValues();
    }

    public function computerThrow()
    {
        $this->computerHand->resetValues();
        $this->computerHand->resetValue();
        $sum = 0;
        while (!in_array(1, $this->computerHand->values())) {
            $this->computerHand->roll();
            $check = array_intersect([4,5,6], $this->computerHand->values());
            $this->serie = $this->computerHand->allValues();
            $sum += $this->computerHand->sum();
            if (!in_array(1, $this->computerHand->values()) && count($check) == 2) {
                $this->p2Score += $sum;
                break;
            }
        }
        $this->serie = $this->computerHand->allValues();
        return $this->computerHand->values();
    }

    public function getHistogramMax()
    {
        return $this->sides;
    }

    // public function p1Play() {
    //     $this->computerHand->roll();
    //     return [$this->computerHand->values(), $this->computerHand->sum()];
    // }

    public function isOver()
    {
        $returnValue = false;
        if ($this->p1Score >= 100 || $this->p2Score >= 100) {
            $returnValue = true;
        }
        return $returnValue;
    }

    public function getP1()
    {
        return $this->p1Score;
    }

    public function getP2()
    {
        return $this->p2Score;
    }

    public function setSerie($serie)
    {
        $this->serie = $serie;
    }
}
