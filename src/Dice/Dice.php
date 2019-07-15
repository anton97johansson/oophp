<?php

namespace Anjj16\Dice;

class Dice
{
    protected $value;
    protected $sides;

    public function __construct(int $sides = 6)
    {
        $this->sides = $sides;
    }
    public function throw()
    {
        $this->value = rand(1, 6);
    }

    public function getValue() : int
    {
        return $this->value;
    }
}
