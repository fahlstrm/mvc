<?php

declare(strict_types=1);

namespace Frah\YatzyGame;

class Game
{
    const DICE = 5;
    private array $scoreExtra;
    private array $scoreBoard;
    private int $thisRound;
    public object $diceHand;
    public array $data;

    public function __construct(DiceInterface $diceHand)
    {
        $this->scoreBoard = [
            1 => null,
            2 => null,
            3 => null,
            4 => null,
            5 => null,
            6 => null
        ];
        $this->scoreExtra = [
            "yatzy" => null,
            "summa" => 0,
            "bonus" => null
        ];
        $this->diceHand = $diceHand;
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
        $iterations = count($lastRoll);
        for ($i = 0; $i < $iterations; $i++) {
            if (isset($rollAgain[$i])) {
                $this->diceHand->dices[$i]->roll();
            }
        }
        $this->setThisRound();
        $this->data["rolled"] = $this->diceHand->getLastRoll();
        return $this->mergeDefaultData($this->data);
    }

    public function updateScoreBoard($choosen): array
    {
        $lastRoll = $this->diceHand->getLastRoll();
        foreach ($lastRoll as $val) {
            if (intval($choosen) == $val) {
                if (is_null($this->scoreBoard[$choosen])) {
                    $this->scoreBoard[$choosen] = $val;
                    continue;
                }
                $this->scoreBoard[$choosen] = $this->scoreBoard[$choosen] + $choosen;
            }
        }
        if (!in_array($choosen, $lastRoll)) {
            $this->scoreBoard[$choosen] = 0;
        }

        if ($this->checkScoreBoard() == false) {
            $this->resetThisRound();
            $this->diceHand->roll();
            $this->checkYatzy();
        } else if ($this->checkScoreBoard()) {
            $this->finalScore();
        }

        $this->data["rolled"] = $this->diceHand->getLastRoll();
        return $this->mergeDefaultData($this->data);
    }

    public function finalScore(): bool
    {
        if ($this->checkScoreBoard()) {
            $this->setBonus();
            $this->setScore();
            return true;
        }
        return false;
    }

    /*
    * array_uniqe removes duplicates from array.
    * If array count == 1 when done, all values are equal
    * If array count greater, there are missmatch in array meaning no yatzy
    */
    public function checkYatzy(): bool
    {
        $dices = $this->diceHand->getLastRoll();
        $check = (count(array_unique($dices)) === 1);
        if ($check == "true") {
            $this->scoreExtra["yatzy"] = 50;
            $this->resetRoll();
            return true;
        }
        return $check;
    }


    public function resetRoll(): array
    {
        $this->resetThisRound();
        $this->diceHand->roll();
        return $this->diceHand->dices;
    }


    public function checkScoreBoard(): bool
    {
        foreach (array_keys($this->scoreBoard) as $key) {
            if (is_null($this->scoreBoard[$key])) {
                return false;
            }
        }
        return true;
    }


    public function getScoreBoard(): array
    {
        return $this->scoreBoard;
    }

    public function setScoreBoard($values): array
    {
        for ($i = 1; $i < count($values)+1; $i++) {
            $this->scoreBoard[$i] = $values[$i];
        }

        return $this->scoreBoard;
    }


    public function getScore(): int
    {
        return $this->scoreExtra["summa"];
    }


    public function setScore(): void
    {
        foreach ($this->scoreBoard as $value) {
            $this->scoreExtra["summa"] = $this->scoreExtra["summa"] + $value;
        }
        if (isset($this->scoreExtra["bonus"])) {
            $this->scoreExtra["summa"] += $this->scoreExtra["bonus"];
        }
        if (isset($this->scoreExtra["yatzy"])) {
            $this->scoreExtra["summa"] += $this->scoreExtra["yatzy"];
        }
    }


    public function setBonus(): int
    {
        $this->scoreExtra["bonus"] = $this->scoreExtra["summa"] >= 63 ? 50 : 0;
        return $this->scoreExtra["bonus"];
    }


    public function getScoreExtra(): array
    {
        return $this->scoreExtra;
    }

    public function setScoreExtraSumma($sum): int
    {
        $this->scoreExtra["summa"] = $sum;
        return $this->scoreExtra["summa"];
    }

    

    public function setScoreExtraYatzy(): int
    {
        $this->scoreExtra["yatzy"] = 50;
        return $this->scoreExtra["yatzy"];
    }


    public function resetThisRound(): int
    {
        $this->thisRound = 1;
        return $this->thisRound;
    }



    public function resetGame(): array
    {
        $this->scoreBoard = [
            1 => null,
            2 => null,
            3 => null,
            4 => null,
            5 => null,
            6 => null
        ];
        $this->scoreExtra = [
            "yatzy" => null,
            "summa" => null,
            "bonus" => null
        ];
        $this->thisRound = 0;

        $data = $this->startGame();
        return $this->mergeDefaultData($data);
    }


    public function mergeDefaultData($data = []): array
    {
        $default = [
            "header" => "Fem lika innebär YATZY!",
            "message" => "Bocka i de tärningar du vill slå om, antal slag kvar:",
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
