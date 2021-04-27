<?php 

declare(strict_types=1);

namespace Frah\YatzyGame;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

/**
 * Test methods in Yatzy game class
 */
class YatzyTest extends TestCase
{
    private object $game; 

    protected function setUp(): void
    {
        $this->diceHand = 
        $this->game = new Game();
        $stubDH = $this->createStub("diceHand");
        
    }

    /**
     * Test that when starting game a array with data is returned
     */
    public function testStartGame()
    {
        $res = $this->game->startGame();
        $this->assertIsArray($res);
    }

    public function testSetThisRound()
    {
        $res = $this->game->setThisRound();
        $exp = 1;
        $this->assertEquals($exp, $res);
    }

    public function testGetThisRound()
    {
        $res = $this->game->getThisRound();
        $exp = 0;
        $this->assertEquals($exp, $res);
    }

    /**
     * Kräver mock?
     */
    // public function testRollAgain()
    // {
        
    //     $res = $game->rollAgain();
    //     $this->asserTyp
    // }

    /**
     * Test that method checkScoreBoard returns false when starting the game
     */

    public function testCheckScoreBoard()
    {
        $res = $this->game->checkScoreBoard();
        $this->assertFalse($res);
    }

    public function testGetScoreBoard()
    {
        $res = $this->game->getScoreBoard();
        $this->assertIsArray($res);
    }

    /**
     * test that extra sum is set to 0 in beginning of game
     */
    public function testGetScore()
    {
        $res = $this->game->getScore();
        $exp = 0;
        $this->assertEquals($exp, $res);
    }

    // public function testSetBonus()
    // {
    //     $this->game->scoreExtra["summa"] = 63;
    //     $res = $this->game->getScoreExtra
    // }
}


class DiceHandTest implements DiceInterface
{
    public array $dices;
    public ?int $sum = null;

    public function __construct($amount)
    {
        for ($i = 0; $i < $amount; $i++) {
            $this->dices[$i] = new GameDice();
        }
    }

    public function roll(): void
    {
        $len = count($this->dices);

        for ($i = 0; $i < $len; $i++) {
            $this->sum += $this->dices[$i]->roll();
        }
    }

    public function getLastRoll(): array
    {
        $len = count($this->dices);
        $res = [];
        for ($i = 0; $i < $len; $i++) {
            $res[$i] = $this->dices[$i]->getLastRoll();
        }
        return $res;
    }
}
