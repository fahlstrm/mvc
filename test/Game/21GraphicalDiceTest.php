<?php 

declare(strict_types=1);

namespace Frah\DiceGame;

use PHPUnit\Framework\TestCase;

class TwentyOneGraphDiceTest extends TestCase 
{
    /**
     * Yatzy GameDice class uses DiceTrait
     */
    private object $dice;

    protected function setUp(): void
    {
        $this->dice = new GraphicalDice();
    }

    public function testRollGameDice()
    {
        $res = $this->dice->roll();
        $this->assertIsNumeric($res);
    }

    public function testGetLastRollGameDice()
    {
        $rolled = $this->dice->roll();
        $res = $this->dice->getLastRoll();
        $this->assertEquals($res, $rolled);
    }
}