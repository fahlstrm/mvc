<?php

/**
 * A game-dice implementing DiceInterface, using DiceTrait to fufill
 */

declare(strict_types=1);

namespace Frah\YatzyGame;

class GameDice implements DiceInterface
{
    use DiceTrait;
}
