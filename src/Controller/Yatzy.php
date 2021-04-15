<?php
declare(strict_types=1);

namespace Mos\Controller;


use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Message\ResponseInterface;

use function Mos\Functions\renderView;

use Frah\YatzyGame;

class Yatzy
{
    public function start(): ResponseInterface
    {
        $psr17Factory = new Psr17Factory();

        $callable = new \Frah\YatzyGame\Game();
        $_SESSION["yazty"] = $callable;
        $data = $callable->startGame(); 
        
        $body = renderView("layout/yatzyGame.php", $data);

        return $psr17Factory
            ->createResponse(200)
            ->withBody($psr17Factory->createStream($body));
    }

    public function roll(): ResponseInterface
    {
        $psr17Factory = new Psr17Factory();

        $callable = $_SESSION["yazty"];
        var_dump(count($_POST));
        

        $body = renderView("layout/yatzyGame.php", $data);

        return $psr17Factory
            ->createResponse(200)
            ->withBody($psr17Factory->createStream($body));
    }

    public function save(): ResponseInterface
    {
        $psr17Factory = new Psr17Factory();

        $callable = $_SESSION["yazty"];


        $body = renderView("layout/yatzyGame.php", $data);

        return $psr17Factory
            ->createResponse(200)
            ->withBody($psr17Factory->createStream($body));
    }

}