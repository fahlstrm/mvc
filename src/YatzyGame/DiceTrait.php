<?php 

declare(strict_types=1);
/*
* Basic trait of a Dice
*/

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
        return $this->roll;
    }

    public function getLastRoll(): int
    {
        return $this->roll;
    }
}