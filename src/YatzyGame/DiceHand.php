<?php

declare(strict_types=1);

namespace Frah\YatzyGame;

class DiceHand implements DiceInterface
{
    public array $dices;
    public ?int $sum = null;

    public function __construct(int $amount, object $dice)
    {
        for ($i = 0; $i < $amount; $i++) {
            $this->dices[$i] = new $dice;
        }
    }

    public function roll(): array
    {
        $len = count($this->dices);

        for ($i = 0; $i < $len; $i++) {
            $this->sum += $this->dices[$i]->roll();
        }

        return $this->dices;
    }

    public function getLastRoll(): array
    {
        $len = count($this->dices);
        $res = [];
        for ($i = 0; $i < $len; $i++) {
            $res[$i] = $this->dices[$i]->getLastRoll();
        }
        return $res;
    }
}
