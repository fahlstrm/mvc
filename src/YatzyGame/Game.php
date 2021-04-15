<?php

declare(strict_types=1);

namespace Frah\YatzyGame;


class Game {
    const DICE = 5;
    private array $scoreBoard;
    private int $score;

    public function __construct() {
        $this->scoreBoard = [
            1 => null,
            2 => null,
            3 => 6,
            4 => null,
            5 => null,
            6 => null,
            "yatzy" => null,
            "bonus" => null
        ];
        $this->score = 0;
        $this->diceHand = new DiceHand(self::DICE);
    }

    

    public function startGame(): array
    {
        $this->diceHand->roll();
        $data = [
            "header" => "Fem lika innebär YATZY!",
            "message" => "Bocka i de tärningar du vill behålla",
            "score" => $this->getScore(),
            "scoreboard" => $this->getScoreBoard(),
            "rolled" => $this->diceHand->getLastRoll()
        ];

        return $data;
    }


    public function getScoreBoard(): array
    {
        return $this->scoreBoard;
    }

    public function getScore(): int
    {
        foreach ($this->scoreBoard as $key => $value) {
            $this->score += $value;
        }
        return $this->score;
    }


    public function mergeDefaultData($data): array
    {   
        $default = [
            "score" => $this->score,
        ];

        $data = array_merge($data, $default);
        return $data;
    }
}