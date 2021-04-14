<?php

declare(strict_types=1);

namespace Frah\DiceGame;

class Game
{
    private int $computerScore;
    private int $playerScore;
    private object $playersDice;
    private object $computersDice;
    public array $data;

    public function __construct()
    {
        $this->computerScore = 0;
        $this->playerScore = 0;
    }

    public function startGame(): void
    {
        $this->data = [
            "header" => "Börja spelet",
            "message" => "Välj antal tärningar att spela med",
            "winner" => null
        ];
        $this->view($this->data);
    }

    public function playGamePlayer($data): void
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
        $this->view($data);
    }

    public function playGameComputer($data): void
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
        $this->view($data);
    }


    private function setScore($winner): void
    {
        if ($winner == "computer") {
            $this->computerScore += 1;
            return;
        }
        $this->playerScore += 1;
        return;
    }


    private function resetGame(): void
    {
        $this->data = [
            "computersum" => null,
            "playersum" => null,
            "gameOver" => null,
        ];
        $_SESSION["continue"] = "play";
        $_SESSION["newGame"] = true;
    }

    public function resetScore(): void
    {
        $this->computerScore = 0;
        $this->playerScore = 0;
        $this->resetGame();
    }


    public function createDices($amount): void
    {
        $this->playersDice = new DiceHand($amount);
        $this->computersDice = new DiceHand($amount);
    }


    public function view($data): void
    {
        $default = [
            "playerScore" => $this->playerScore,
            "computerScore" => $this->computerScore,
        ];
        $data = array_merge($data, $default);
        $body = \Mos\Functions\renderView("layout/diceGame.php", $data);
        \Mos\Functions\sendResponse($body);
    }
}
