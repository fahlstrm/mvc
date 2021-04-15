<?php 

declare(strict_types=1);
/*
* Interface what a dice should contain
*/

namespace Frah\YatzyGame;

interface DiceInterface
{
    public function __construct($amount);
    public function roll();
    public function getLastRoll();
}