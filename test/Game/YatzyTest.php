<?php 

declare(strict_types=1);

namespace Frah\YatzyGame;

use PHPUnit\Framework\TestCase;
// use Psr\Http\Message\ResponseInterface;

/**
 * Test methods in Yatzy game class
 */
class YatzyTest extends TestCase
{
    private object $game; 

    protected function setUp(): void
    {
        // $mockDice = $this->createMock("\Frah\YatzyGame\GameDice");
        // $mockDice = $this->getMockBuilder("\Frah\YatzyGame\GameDice")->getMock();
        // $mockDice->roll = 6;
        // $mockDice->method("getLastRoll")->willReturn(6);
        // $mockDice->method("roll")->willReturn(6);

        // $mockHand = $this->getMockBuilder("\Frah\YatzyGame\DiceHand")
        //         ->setConstructorArgs(array(5, $mockDice))
        //         ->getMock();
        // $mockHand->dices = [$mockDice, $mockDice, $mockDice, $mockDice, $mockDice];

        // $mockHand->method("getLastRoll")->willReturn([6, 6, 1, 6, 5]);
        // $this->game = new Game($mockHand);
        // $this->game->diceHand->getLastRoll();
        $this->game = new Game(new DiceHand(5, new GameDice));
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
     * Testing roll again method by getting last roll, saving the first value
     * Create a array to throw again
     * Checking that the saved value are still the same
     */
    public function testRollAgain()
    {
        $this->game->startGame();
        $last = $this->game->diceHand->getLastRoll();
        $exp = $last[0];
        $throw = array("1"=> $last[1], "2"=> $last[2], "3" =>  $last[3], "4" => $last[4]);
        $res = $this->game->rollAgain($throw, $last);
        $this->assertEquals($exp, $res["rolled"][0]);
    }

    /**
     * Testing test roll again by saving two values and that the remain the same
     */
    public function testRollAgainTwo()
    {
        $this->game->startGame();
        $last = $this->game->diceHand->getLastRoll();
        $exp = array($last[0], $last[4]);
        $throw = array("1"=> $last[1], "2"=> $last[2], "3" =>  $last[3]);
        $res = $this->game->rollAgain($throw, $last);
        $this->assertEquals($exp, [$res["rolled"][0], $res["rolled"][4]]);
    }


    // public function testUpdateScoreBoard()
    // {
    //     $res = $this->game->rollAgain();
    // }


    public function testFinalScore()
    {
        $scoreBoard = [
            1 => 3,
            2 => 6,
            3 => 6,
            4 => 16,
            5 => 15,
            6 => 12
        ];
        $this->game->setScoreBoard($scoreBoard);
        $res = $this->game->finalScore();
        $this->assertTrue($res);
    }


    public function testCheckYatzy()
    {
        $this->game->diceHand->roll();
        $res = $this->game->checkYatzy();
        $this->assertFalse($res);
    }

    /**
     * Using a mock object to be able to make false yatzy
     */
    public function testCheckYatzyTrue()
    {
        $mockDice = $this->createMock("\Frah\YatzyGame\GameDice");
        $mockDice = $this->getMockBuilder("\Frah\YatzyGame\GameDice")->getMock();
        $mockDice->roll = 6;
        $mockDice->method("getLastRoll")->willReturn(6);
        $mockDice->method("roll")->willReturn(6);
        $mockHand = $this->getMockBuilder("\Frah\YatzyGame\DiceHand")
                ->setConstructorArgs(array(5, $mockDice))
                ->getMock();
        $mockHand->method("getLastRoll")->willReturn([6, 6, 6, 6, 6]);

        $this->game->diceHand = $mockHand;
        $res = $this->game->checkYatzy();
        $this->assertTrue($res);
    }


    public function testResetRoll()
    {
        $res = $this->game->resetRoll();
        $this->assertIsArray($res);
    }

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


    // public function testSetScore()
    // {

    // }

    public function testGetScoreExtra()
    {
        $res = $this->game->getScoreExtra();
        $this->assertIsArray($res);
    }

    public function testSetScore()
    {
        $exp = $this->game->setScoreExtraSumma(63);
        $this->assertEquals(63, $exp);

        $res = $this->game->setBonus();
        $bonus = 50;
        $this->assertEquals($bonus, $res);
    }

    public function testResetThisRound()
    {
        $this->game->setThisRound();
        $this->game->setThisRound();
        $res = $this->game->setThisRound();
        $this->assertEquals(3, $res);

        $res = $this->game->resetThisRound();
        $this->assertEquals(1, $res);
    }

    public function testResetGame() 
    {
        $res = $this->game->resetGame();
        $this->assertIsArray($res);
    }

    // public function testMergeDefaultData()
    // {
    //     $res = $this->game->mergeDefaultData([1, 2, 3, "test"]);
    //     $this->assertEquals($res[0], 1);
    // }

}



