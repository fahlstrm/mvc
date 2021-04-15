<?php

declare(strict_types=1);
/**
 * A game-dice implementing DiceInterface, using DiceTrait to fufill 
 */

namespace Frah\YatzyGame;

class GameDice implements DiceInterface
{
    use DiceTrait;
}
