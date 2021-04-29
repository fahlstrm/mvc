<?php 

declare(strict_types=1);

namespace Frah\DiceGame;

use PHPUnit\Framework\TestCase;

class TwentyoneDiceHandTest extends TestCase 
{
    /**
     * Testing functions of DiceHand in Yatzy game
     */
    private object $diceHand;

    protected function setUp(): void
    {
        $this->diceHand = new DiceHand(5, new Dice);
    }

    public function testRollHandTwentyOne()
    {
        $res = $this->diceHand->roll();
        $this->assertIsInt($res);
    }

    public function testLastRollTwentyOne()
    {
        $rolled = $this->diceHand->roll();
        $res = $this->diceHand->lastRoll();
        $this->assertIsString($res);
    }
}