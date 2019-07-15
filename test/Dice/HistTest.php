<?php

namespace Anjj16\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Guess.
 */
class HistTest extends TestCase
{
    /**
    * Construct a dice object and rolls it
    *
    *
    */
    public function testPrint()
    {
        $hist = new Histogram();
        $this->assertInstanceOf("\Anjj16\Dice\Histogram", $hist);
        $game = new DiceHandler();
        $game->setSerie([1]);
        $hist->injectData($game);
        $val = $hist->getAsText();
        $this->assertInternalType("string", $val);
    }
}
