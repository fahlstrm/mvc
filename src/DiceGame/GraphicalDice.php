<?php

declare(strict_types=1);

namespace Frah\DiceGame;

class GraphicalDice extends Dice
{
    const FACES = 6;

    public function __construct()
    {
        parent::__construct(self::FACES);
    }
}
