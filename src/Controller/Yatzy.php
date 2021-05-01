<?php

declare(strict_types=1);

namespace Mos\Controller;

use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Message\ResponseInterface;

use function Mos\Functions\renderView;
use Frah\YatzyGame\GameDice;
use Frah\YatzyGame\DiceHand;
use Frah\YatzyGame\Game;


class Yatzy
{
    public function start(): ResponseInterface
    {
        $psr17Factory = new Psr17Factory();
        $callable = new Game(new DiceHand(5, new GameDice));
        $_SESSION["yatzyobject"] = $callable;
        $data = $callable->startGame();

        $body = renderView("layout/yatzyGame.php", $data);

        return $psr17Factory
            ->createResponse(200)
            ->withBody($psr17Factory->createStream($body));
    }

    public function roll(): ResponseInterface
    {
        $psr17Factory = new Psr17Factory();

        $callable = $_SESSION["yatzyobject"];
        $data = $callable->rollAgain($_POST, $callable->diceHand->getLastRoll());
        // echo($data["gameover"]);

        $body = renderView("layout/yatzyGame.php", $data);
        // var_dump($data["yatzy"]);
        return $psr17Factory
            ->createResponse(200)
            ->withBody($psr17Factory->createStream($body));
    }

    public function save(): ResponseInterface
    {
        $psr17Factory = new Psr17Factory();

        $callable = $_SESSION["yatzyobject"];
        $data = $callable->updateScoreBoard($_POST["values"] ?? null);

        $body = renderView("layout/yatzyGame.php", $data);

        return $psr17Factory
            ->createResponse(200)
            ->withBody($psr17Factory->createStream($body));
    }

    public function reset(): ResponseInterface
    {
        $psr17Factory = new Psr17Factory();

        $callable = $_SESSION["yatzyobject"];
        $data = $callable->resetGame();

        $body = renderView("layout/yatzyGame.php", $data);

        return $psr17Factory
            ->createResponse(200)
            ->withBody($psr17Factory->createStream($body));
    }
}
