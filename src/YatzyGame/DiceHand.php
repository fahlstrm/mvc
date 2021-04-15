<?php

declare(strict_types=1);

namespace Frah\YatzyGame;

class DiceHand implements DiceInterface
{
    use DiceTrait;
    public array $dices;
    public ?int $sum = null;

    public function __construct($amount)
    {
        for ($i = 0; $i < $amount; $i++) {
            $this->dices[$i] = new GameDice();
        }
    }

    public function roll(): void
    {
        $len = count($this->dices);

        for ($i = 0; $i < $len; $i++) {
            $this->sum += $this->dices[$i]->roll();
        }
    }

    public function getLastRoll(): array
    {
        $len = count($this->dices);
        $res = [];
        for ($i = 0; $i < $len; $i++) {
            $res[$i]= $this->dices[$i]->getLastRoll();
        }
        // $res = substr($res, 0, -2);
        return $res;
    }
}
