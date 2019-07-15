<?php

namespace Anjj16\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Guess.
 */
class DiceTest extends TestCase
{
    /**
    * Construct a dice object and rolls it
    *
    *
    */
    public function testThrow()
    {
        $dice = new Dice();
        $this->assertInstanceOf("\Anjj16\Dice\Dice", $dice);

        $dice->throw();
        $val = $dice->getValue();
        $this->assertInternalType("int", $val);
    }
}
