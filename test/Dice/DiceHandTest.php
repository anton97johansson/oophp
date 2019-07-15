<?php

namespace Anjj16\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Guess.
 */
class DiceHandTest extends TestCase
{
    /**
    * Construct a dicehand object with three dices and rolls them
    *
    *
    */
    public function testThrowAndNumberOfDices()
    {
        $dice = new DiceHand(3);
        $this->assertInstanceOf("\Anjj16\Dice\DiceHand", $dice);

        $dice->roll();
        $val = $dice->values();
        $this->assertEquals(3, sizeof($val));
    }

    /**
    * check if sum is correct
    *
    *
    */
    public function testSumOfDices()
    {
        $hand = new DiceHand();
        $hand->roll();
        $val = $hand->sum();
        $exp = array_sum($hand->values());
        $this->assertEquals($exp, $val);
    }
}
