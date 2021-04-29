<?php

declare(strict_types=1);

namespace Frah\DiceGame;

class Game
{
    private int $computerScore;
    private int $playerScore;
    public object $playersDice;
    public object $computersDice;
    public array $data;

    public function __construct()
    {
        $this->computerScore = 0;
        $this->playerScore = 0;
    }

    public function startGame(): array
    {
        $this->data = [
            "header" => "Börja spelet",
            "message" => "Välj antal tärningar att spela med",
            "winner" => null,
            "playersScore" => $this->playerScore,
            "computerScore" => $this->computerScore,
        ];
        $data = $this->mergeData($this->data);
        return $data;
    }

    public function playGamePlayer($data): array
    {
        $this->playersDice->roll();
        $data["player"] = $this->playersDice->lastRoll();
        $data["playersum"] = $this->playersDice->sum;
        if ($data["playersum"] == 21 || $data["playersum"] > 21) {
            if ($data["playersum"] == 21) {
                $data["winner"] = "Grattis!";
                $data["computersum"] = "Datorn behövde inte slå";
                $this->setScore("player");
            } else if ($data["playersum"] > 21) {
                $data["winner"] = "Du har förlorat, trist!";
                $data["computersum"] = "Datorn behövde inte slå";
                $this->setScore("computer");
            }
            $data["gameover"] = 1;
            $this->resetGame();
            $data["message"] = "Välj antal tärningar om du vill starta ny omgång";
        }
        // var_dump($data);
        $result = $this->mergeData($data);
        return $result;
    }

    public function playGameComputer($data): array
    {
        $pSum = $this->playersDice->sum;
        $winner = null;

        while ($this->computersDice->sum < $pSum) {
            $this->computersDice->roll();
        }
        $cSum = $this->computersDice->sum;
        if ($cSum > $pSum && $cSum <= 21 || $cSum == $pSum) {
            $data["gameover"] = 1;
            $winner = "Datorn vann! Du förlorade";
            $this->setScore("computer");
        } else if ($cSum > $pSum && $cSum > 21) {
            $data["gameover"] = 1;
            $winner = "Grattis! Du vann!";
            $this->setScore("player");
        }
        $data["gameover"] = 1;
        $this->resetGame();
        $data["message"] = "Välj antal tärningar om du vill starta ny omgång";
        $data["winner"] = $winner;
        $data["computersum"] = $cSum;
        $data["playersum"] = $pSum;
        $data["player"] = $this->playersDice->sum;
        $data = $this->mergeData($data);
        return $data;
    }


    public function setScore($winner): int
    {
        if ($winner == "computer") {
            $this->computerScore += 1;
            return $this->computerScore;
        }
        $this->playerScore += 1;
        return $this->playerScore;
    }

    public function getPlayerScore(): int
    {
        return $this->playerScore;
    }

    public function getComputerScore(): int
    {
        return $this->computerScore;
    }


    private function resetGame(): array
    {
        $this->data = [
            "computersum" => null,
            "playersum" => null,
            "gameOver" => null,
        ];
        $_SESSION["continue"] = "play";
        $_SESSION["newGame"] = true;
        return $this->data;
    }

    public function resetScore(): void
    {
        $this->computerScore = 0;
        $this->playerScore = 0;
        $this->resetGame();
    }


    public function createDices($amount): void
    {
        $this->playersDice = new DiceHand($amount, new Dice());
        $this->computersDice = new DiceHand($amount, new Dice());
    }


    public function mergeData($data): array
    {
        $default = [
            "playerScore" => $this->playerScore,
            "computerScore" => $this->computerScore,
        ];

        $data = array_merge($data, $default);
        return $data;
    }
}
