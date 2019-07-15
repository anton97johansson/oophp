<?php

namespace Anjj16\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Guess.
 */
class DiceHandlerTest extends TestCase
{
    /**
    * Construct a dicehandler object
    *
    *
    */
    public function testObject()
    {
        $dice = new DiceHandler();
        $this->assertInstanceOf("\Anjj16\Dice\DiceHandler", $dice);
    }

    /**
    * check if p1 updates correctly is correct
    *
    *
    */
    public function testUpdateScore()
    {
        $hand = new DiceHandler();
        $hand->p1Save(33);
        $val = 33;
        $exp = $hand->getP1();
        $this->assertEquals($exp, $val);
    }

    /**
    * check if isOver Works, by exceeding 100
    *
    *
    */
    public function testExceedingMaxScore()
    {
        $hand = new DiceHandler();
        $hand->p1Save(333);
        $val = $hand->isOver();
        $exp = true;
        $this->assertEquals($exp, $val);
    }

    /**
    * check if p2 returns
    *
    *
    */
    public function testP2Score()
    {
        $hand = new DiceHandler();
        $val = 0;
        $exp = $hand->getP2();
        $this->assertEquals($exp, $val);
    }

    /**
    * check if serie gets filled with dice values
    *
    *
    */
    public function testSetSerie()
    {
        $hand = new DiceHandler();
        $val = 6;
        $hand->setSerie([1,5,6,2,5,5]);
        $exp = count($hand->getHistogramSerie());
        $this->assertEquals($exp, $val);
    }

    /**
    * check if serie gets reseted
    *
    *
    */
    public function testClearSerie()
    {
        $hand = new DiceHandler();
        $val = 0;
        $hand->setSerie([1,5,6,2,5,5]);
        $hand->resetSerie();
        $exp = count($hand->getHistogramSerie());
        $this->assertEquals($exp, $val);
    }

    /**
    * check if hist min is 1
    *
    *
    */
    public function testHistMin()
    {
        $hand = new DiceHandler();
        $val = 1;
        $exp = $hand->getHistogramMin();
        $this->assertEquals($exp, $val);
    }
}
