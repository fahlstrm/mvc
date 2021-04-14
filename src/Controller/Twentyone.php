<?php
declare(strict_types=1);

namespace Mos\Controller;


use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Message\ResponseInterface;

use function Mos\Functions\renderView;


class Twentyone
{
    public function start(): ResponseInterface
    {
        $psr17Factory = new Psr17Factory();

        $data = [
            "header" => "Spelet 21",
            "message" => "Välj antal tärningar",
        ];
        $callable = new \Frah\DiceGame\Game();
        $callable->startGame();
        $_SESSION["object"] = $callable;
        $_SESSION["continue"] = "play";

        $body = renderView("layout/diceGame.php", $data);

        return $psr17Factory
            ->createResponse(200)
            ->withBody($psr17Factory->createStream($body));
    }

    public function play(): ResponseInterface
    {
        $psr17Factory = new Psr17Factory();

        $data = [
            "header" => "Spelet 21",
            "message" => "Välj antal tärningar",
        ];

        $_SESSION["object"]->createDices(intval($_SESSION["amount"]));
        $_SESSION["object"]->data = [
            "header" => "Kom igen då!",
            "message" => "Tryck på fortsätt om du vill fortsätta"
        ];
        $_SESSION["continue"] = "ongoing";

        $_SESSION["object"]->playGamePlayer($_SESSION["object"]->data);

        $body = renderView("layout/diceGame.php", $data);

        return $psr17Factory
            ->createResponse(200)
            ->withBody($psr17Factory->createStream($body));
    }

    public function continue(): ResponseInterface
    {
        $psr17Factory = new Psr17Factory();

        $data = [
            "header" => "Spelet 21",
            "message" => "Välj antal tärningar",
        ];

        $_SESSION["object"]->playGamePlayer($_SESSION["object"]->data);

        $body = renderView("layout/diceGame.php", $data);

        return $psr17Factory
            ->createResponse(200)
            ->withBody($psr17Factory->createStream($body));
    }

    public function computersTurn(): ResponseInterface
    {
        $psr17Factory = new Psr17Factory();

        $data = [
            "header" => "Spelet 21",
            "message" => "Välj antal tärningar",
        ];

        $_SESSION["object"]->playGameComputer($_SESSION["object"]->data);

        $body = renderView("layout/diceGame.php", $data);

        return $psr17Factory
            ->createResponse(200)
            ->withBody($psr17Factory->createStream($body));
    }


    public function newGame(): ResponseInterface
    {
        $psr17Factory = new Psr17Factory();

        $data = [
            "header" => "Spelet 21",
            "message" => "Välj antal tärningar",
        ];
        $_SESSION["amount"] = $_POST["amount"] ?? null;
        $_SESSION["newGame"] = null;

        $body = renderView("layout/diceGame.php", $data);

        return $psr17Factory
            ->createResponse(200)
            ->withBody($psr17Factory->createStream($body));
    }


    public function continueGame(): ResponseInterface
    {
        $psr17Factory = new Psr17Factory();

        $data = [
            "header" => "Spelet 21",
            "message" => "Välj antal tärningar",
        ];
        $_SESSION["continue"] = array_key_first($_POST);

        $body = renderView("layout/diceGame.php", $data);

        return $psr17Factory
            ->createResponse(200)
            ->withBody($psr17Factory->createStream($body));
    }

    public function reset(): ResponseInterface
    {
        $psr17Factory = new Psr17Factory();

        $data = [
            "header" => "Spelet 21",
            "message" => "Välj antal tärningar",
        ];
        $_SESSION["object"]->resetScore();

        $body = renderView("layout/diceGame.php", $data);

        return $psr17Factory
            ->createResponse(200)
            ->withBody($psr17Factory->createStream($body));
    }
}