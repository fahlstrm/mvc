<?php

/*
* Interface what a dice should contain
*/

declare(strict_types=1);

namespace Frah\YatzyGame;

interface DiceInterface
{
    public function __construct($amount);
    public function roll();
    public function getLastRoll();
}
