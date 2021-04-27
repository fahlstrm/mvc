<?php

/*
* Basic trait of a Dice
*/

declare(strict_types=1);

namespace Frah\YatzyGame;

trait DiceTrait
{
    public int $faces;
    private int $roll;

    public function __construct($faces = 6)
    {
        $this->faces = $faces;
    }

    public function roll(): int
    {
        $this->roll = rand(1, 6);
        // echo($this->roll);
        return $this->roll;
    }

    public function getLastRoll(): int
    {
        return $this->roll;
    }
}
