<?php

declare(strict_types=1);

namespace Frah\YatzyGame;


class Game {
    const DICE = 5;
    private array $scoreExtra;
    private array $scoreBoard;
    private int $score;
    private int $thisRound;


    public function __construct() {
        $this->scoreBoard = [
            1 => 2,
            2 => 2,
            3 => null,
            4 => 4,
            5 => 2,
            6 => null
        ];
        $this->scoreExtra = [
            "yatzy" => null,
            "summa" => null,
            "bonus" => null
        ];
        $this->score = 0;
        $this->diceHand = new DiceHand(self::DICE);
        $this->thisRound = 0;
    }


    public function startGame(): array
    {
        $this->diceHand->roll();
        $this->checkYatzy();
        $this->setThisRound();
        $data = [
            "rolled" => $this->diceHand->getLastRoll()
        ];

        return $this->mergeDefaultData($data);
    }

    public function setThisRound(): int
    {
        return ($this->thisRound += 1);
    }

    public function getThisRound(): int
    {
        return $this->thisRound;
    }


    public function rollAgain($rollAgain, $lastRoll): array
    {
        for ($i = 0; $i < count($lastRoll); $i++) {
            if (isset($rollAgain[$i])) {
                $this->diceHand->dices[$i]->roll();
            }
        }
        $this->setThisRound();
        $data["rolled"] = $this->diceHand->getLastRoll();
        return $this->mergeDefaultData($data);
    }

    public function updateScoreBoard($choosen): array
    {
        $lastRoll = $this->diceHand->getLastRoll();
        foreach ($lastRoll as $key => $val) {
            if (intval($choosen) == $val) {
                if (is_null($this->scoreBoard[$choosen])) {
                    $this->scoreBoard[$choosen] = $val;
                } else {
                    $this->scoreBoard[$choosen] = $this->scoreBoard[$choosen] + $choosen;
                }
            }
        }
        if (!in_array($choosen, $lastRoll)) {
            $this->scoreBoard[$choosen] = 0;
        }

        $this->resetThisRound();
        $this->diceHand->roll();
        $data["rolled"] = $this->diceHand->getLastRoll();
        
        return $this->mergeDefaultData($data);
    }

    public function checkYatzy(): bool
    {
        $dices = $this->diceHand->getLastRoll();
        /*
        * array_uniqe removes duplicates from array. 
        * If array count == 1 when done, all values are equal
        * If array count greater, there are missmatch in array meaning no yatzy
        */ 
        $check = (count(array_unique($dices)) === 1);
        if ($check == "true") {
            $this->scoreExtra["yatzy"] = 50;
        }
        return $check;
    }


    public function checkScoreBoard(): bool 
    {
        foreach ($this->scoreBoard as $value) {
            if (!isset($this->scoreBoard[$value])) {
                return false;
            }
        }
        $this->setScore();
        $this->setBonus();
        return true;
    }


    public function getScoreBoard(): array
    {
        return $this->scoreBoard;
    }

    public function getScore(): int 
    {
        return $this->score;
    }

    public function setScore(): void
    {
        foreach ($this->scoreBoard as $key => $value) {
            $this->score = $this->score + $value;
            $this->scoreExtra["summa"] = $this->scoreExtra["summa"] + $value;
        }
        if (isset($this->scoreExtra["bonus"])) {
            $this->score += $this->scoreExtra["bonus"];
        }
    }

    public function setBonus(): void
    {
        if ($this->score > 63) {
            $this->scoreExtra["bonus"] = 50;
        }
    }

    public function getScoreExtra(): array 
    {
        return $this->scoreExtra;
    }

    private function resetThisRound(): void
    {
        $this->thisRound = 1;
    }


    public function mergeDefaultData($data = []): array
    {   
        $default = [
            "header" => "Fem lika innebär YATZY!",
            "message" => "Bocka i de tärningar du vill slå om, antal slag kvar:",
            "score" => $this->getScore(),
            "scoreboard" => $this->getScoreBoard(),
            "gameover" => $this->checkScoreBoard(),
            "scoreextra" => $this->getScoreExtra(),
            "thisround" => $this->getThisRound(),
            "yatzy" => $this->checkYatzy(),
            
        ];

        $data = array_merge($data, $default);
        return $data;
    }
}