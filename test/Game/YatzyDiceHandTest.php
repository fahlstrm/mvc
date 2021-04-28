<?php 

declare(strict_types=1);

namespace Frah\YatzyGame;

use PHPUnit\Framework\TestCase;

class YatzyDiceHandTest extends TestCase 
{
    /**
     * Testing functions of DiceHand in Yatzy game
     */
    private object $diceHand;

    protected function setUp(): void
    {
        $this->diceHand = new DiceHand(5, new GameDice);
    }

    public function testRollDiceHand()
    {
        $res = $this->diceHand->roll();
        $this->assertIsArray($res);
    }

    public function testGetLastRollGameDice()
    {
        $rolled = $this->diceHand->roll();
        $res = $this->diceHand->getLastRoll();
        $this->assertIsArray($res);
    }
}