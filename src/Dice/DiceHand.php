<?php
namespace Anjj16\Dice;

/**
 * A dicehand, consisting of dices.
 */
class DiceHand
{
    /**
     * @var Dice $dices   Array consisting of dices.
     * @var int  $values  Array consisting of last roll of the dices.
     */
    private $dices;
    private $values;
    private $allValues;

    /**
     * Constructor to initiate the dicehand with a number of dices.
     *
     * @param int $dices Number of dices to create, defaults to five.
     */
    public function __construct(int $dices = 2)
    {
        $this->dices  = [];
        $this->values = [];
        $this->allValues = [];

        for ($i = 0; $i < $dices; $i++) {
            $this->dices[]  = new Dice();
            $this->values[] = null;
        }
    }
    /**
     * Roll all dices save their value.
     *
     * @return void.
     */
    public function roll()
    {
            $this->values = [];
        for ($i = 0; $i < sizeof($this->dices); $i++) {
            $this->dices[$i]->throw();
            $this->values[$i] = $this->dices[$i]->getValue();
            $this->allValues[] = $this->dices[$i]->getValue();
        }
    }

    /**
     * Get values of dices from last roll.
     *
     * @return array with values of the last roll.
     */
    public function values()
    {
        return $this->values;
    }

    public function resetValue()
    {
        $this->values = [];
    }

    public function allValues()
    {
        return $this->allValues;
    }

    public function resetValues()
    {
        return $this->allValues = [];
    }

    /**
     * Get the sum of all dices.
     *
     * @return int as the sum of all dices.
     */
    public function sum()
    {
        return array_sum($this->values);
    }
}
// $e = new DiceHand();
// $e->roll();
// var_dump($e->allValues());
// $e->roll();
// var_dump($e->allValues());
// $e->resetValues();
// var_dump($e->allValues());
