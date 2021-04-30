<?php 

declare(strict_types=1);

namespace Frah\DiceGame;

use PHPUnit\Framework\TestCase;

class TwentyOneGameTest extends TestCase 
{
    /**
     * Testing functions of DiceHand in Yatzy game
     */
    private object $game;

    /**
     * setUp function for the test
     */
    protected function setUp(): void
    {
        $this->game = new Game();
    }

    /**
     * Test that startGame returns array
     */
    public function testStartGame()
    {
        $this->assertIsArray($this->game->startGame());
    }

    /**
     * Using mock to set static values to test the if-else in method
     */
    public function testPlayGamePlayer()
    {
        $this->game->createDices(1);
        $data = [];
        $res = $this->game->playGamePlayer($data);
        $this->assertIsArray($res);

        $mockDice = $this->createMock("\Frah\DiceGame\Dice");
        $mockDice = $this->getMockBuilder("\Frah\DiceGame\Dice")->getMock();
        $mockDice->roll = 0;
        $mockDice->method("getLastRoll")->willReturn(0);
        $mockDice->method("roll")->willReturn(0);
        $playersDice = $this->getMockBuilder("\Frah\DiceGame\DiceHand")
                ->setConstructorArgs(array(1, $mockDice))
                ->getMock();
        $playersDice->sum = 21;

        $this->game->playersDice = $playersDice;

        $res = $this->game->playGamePlayer($data);
        $this->assertEquals("Grattis!", $res["winner"]);

        $playersDice->sum = 23;
        $res = $this->game->playGamePlayer($data);
        $this->assertEquals("Du har förlorat, trist!", $res["winner"]);
    }

    /**
     * Using test double/mock to test the playGameComputer and the if cases within
     */
    public function testPlayGameComputer()
    {
        $this->game->createDices(2);
        $data = [];
        $res = $this->game->playGameComputer($data);
        $this->assertIsArray($res);

        $mockDice = $this->createMock("\Frah\DiceGame\Dice");
        $mockDice = $this->getMockBuilder("\Frah\DiceGame\Dice")->getMock();
        $mockDice->roll = 5;
        $computersDice = $this->getMockBuilder("\Frah\DiceGame\DiceHand")
                ->setConstructorArgs(array(1, $mockDice))
                ->getMock();
        $computersDice->sum = 20;

        $playersDice = $this->getMockBuilder("\Frah\DiceGame\DiceHand")
            ->setConstructorArgs(array(1, $mockDice))
            ->getMock();
        $playersDice->sum = 18;

        $this->game->computersDice = $computersDice;
        $this->game->playersDice = $playersDice;

        $res = $this->game->playGameComputer($data);
        $this->assertEquals("Datorn vann! Du förlorade", $res["winner"]);
    }

    // public function testPlayGameComputerPlayer()
    // {
    //     $data = [];
    //     $mock = $this->createMock("\Frah\DiceGame\Dice");
    //     $mock = $this->getMockBuilder("\Frah\DiceGame\Dice")->getMock();
    //     // $mock->roll = 7;
    //     $mock->method("roll")->willReturn(7);
    //     $computersDice = $this->getMockBuilder("\Frah\DiceGame\DiceHand")
    //             ->setConstructorArgs(array(1, $mock))
    //             ->getMock();
    //     $computersDice->sum = 12;

    //     $playersDice = $this->getMockBuilder("\Frah\DiceGame\DiceHand")
    //         ->setConstructorArgs(array(1, $mock))
    //         ->getMock();
    //     $playersDice->sum = 20;

    //     $this->game->computersDice = $computersDice;
    //     var_Dump($this->game->computersDice->dices);
    //     var_dump($this->game->computersDice->roll());
    //     $this->game->playersDice = $playersDice;

    //     // $res = $this->game->playGameComputer($data);
    //     // $this->assertEquals("Grattis! Du vann!", $res["winner"]);
    // }


    /**
     * Test that setScore function updateds value by 1 each time
     */
    public function testSetScore()
    {
        $res = $this->game->setScore("computer");
        $this->assertEquals(1, $res);

        $res = $this->game->setScore("player");
        $this->assertEquals(1, $res);
    }

    /**
     * Test that getScore method returns correct value after setting it 3 times
     */
    public function testGetPlayerScore()
    {
        $this->game->setScore("player");
        $this->game->setScore("player");
        $this->game->setScore("player");
        $res = $this->game->getPlayerScore();
        $this->assertEquals(3, $res);
        $this->assertIsInt($res);
    }

    /**
     * Test that getScore returns correct value after setting it 2 times
     */
    public function testGetComputerScore()
    {
        $this->game->setScore("computer");
        $this->game->setScore("computer");
        $res = $this->game->getComputerScore();
        $this->assertIsInt($res);
        $this->assertEquals(2, $res);
    }


    /**
     * Using the ReflectionClass API to get private method resetGame
     */
    public function testResetGame()
    {
        $class = new \ReflectionClass("\Frah\DiceGame\Game");
        $method = $class->getMethod("resetGame");
        $method->setAccessible(true); 
        $this->data = [
            "computersum" => 4,
            "playersum" => 2,
            "gameOver" => 1];

        $res = $method->invokeArgs($this->game, []);
        $this->assertEquals(null, $res["computersum"]);
        $this->assertIsArray($res);
    }
    
    /**
     * Test that createdices creates two objects
     */
    public function testCreateDices()
    {
        $class = new \ReflectionClass("\Frah\DiceGame\Game");
        $playersDice = $class->getProperty("playersDice");
        $computersDice = $class->getProperty("computersDice");
        $this->game->createDices(1);
        $this->assertIsObject($computersDice);
        $this->assertIsObject($playersDice);
    }

    /**
     * Test that merge data is array and that it merges with new array
     */
    public function testMergeData()
    {
        $data = [];
        $this->assertIsArray($this->game->mergeData($data));
        $this->assertIsArray($this->game->mergeData($data));
        $this->assertCount(2, $this->game->mergeData($data));

        $data = ["computersum" => 2, "playersum" => 1];
        $this->assertCount(4, $this->game->mergeData($data));

    }

}
