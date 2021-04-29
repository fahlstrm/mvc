<?php 

declare(strict_types=1);

namespace Mos\Controller;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use \Frah\DiceGame;

class ControllerTwentyOneTest extends TestCase
{
    public function testCreateTheControllerClass()
    {
        $controller = new TwentyOne();
        $this->assertInstanceOf("\Mos\Controller\TwentyOne", $controller);
    }

    public function testTwentyOneControllerReturnsResponse()
    {
        $controller = new TwentyOne();

        $exp = "\Psr\Http\Message\ResponseInterface";
        $res = $controller->start();
        $this->assertInstanceOf($exp, $res);

        $res = $controller->play();
        $this->assertInstanceOf($exp, $res);

        
        $res = $controller->continue();
        $this->assertInstanceOf($exp, $res);

        
        $res = $controller->reset();
        $this->assertInstanceOf($exp, $res);
    }
}