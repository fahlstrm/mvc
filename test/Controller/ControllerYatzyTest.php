<?php 

declare(strict_types=1);

namespace Mos\Controller;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;


class ControllerYatzyTest extends TestCase
{
    public function testCreateTheControllerClass()
    {
        $controller = new Yatzy();
        $this->assertInstanceOf("\Mos\Controller\Yatzy", $controller);
    }


    // public function testStartResponse()
    // {
    //     $controller = new Yatzy();
        
    //     $exp = "\Psr\Http\Message\ResponseInterface";
    //     $res = $controller->start();
    //     $this->assertInstanceOf($exp, $res);
    // }
}