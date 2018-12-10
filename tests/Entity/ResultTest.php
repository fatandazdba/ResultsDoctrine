<?php
/**
 * PHP version 7.2
 * tests/Entity/ResultTest.php
 *
 * @category EntityTests
 * @package  MiW\Results\Tests
 * @author   Javier Gil <franciscojavier.gil@upm.es>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://www.etsisi.upm.es ETS de Ingeniería de Sistemas Informáticos
 */

namespace MiW\Results\Tests\Entity;

use MiW\Results\Entity\Result;
use MiW\Results\Entity\User;
use phpmock\phpunit\PHPMock;

/**
 * Class ResultTest
 *
 * @package MiW\Results\Tests\Entity
 */
class ResultTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var User $user
     */
    protected static $user;

    /**
     * @var Result $result
     */
    protected static $result;

    protected static $USERNAME = 'fatandaz';
    protected static $POINTS = 2018;

    /**
     * @var \DateTime $time
     */
    protected static $time;

    /**
     * Sets up the fixture.
     * This method is called before a test is executed.
     *
     * @return void
     * @throws \Exception
     */
    protected function setUp(): void
    {
        self::$user = new User();
        self::$user->setUsername(self::$USERNAME);
        self::$time = new \DateTime('now');
        self::$result = new Result(
            self::$POINTS,
            self::$user,
            self::$time
        );
    }

    /**
     * Implement testConstructor
     *
     * @covers \MiW\Results\Entity\Result::__construct()
     * @covers \MiW\Results\Entity\Result::getId()
     * @covers \MiW\Results\Entity\Result::getResult()
     * @covers \MiW\Results\Entity\Result::getUser()
     * @covers \MiW\Results\Entity\Result::getTime()
     *
     * @return void
     */
    public function testConstructor(): void
    {
        $this->assertEquals("fatandaz",self::$user->getUsername());
    }

    /**
     * Implement testGet_Id().
     *
     * @covers \MiW\Results\Entity\Result::getId()
     * @return void
     */
    public function testGetId():void
    {
        $this->assertEquals(0, self::$user->getId());
    }

    /**
     * Implement testUsername().
     *
     * @covers \MiW\Results\Entity\Result::setResult
     * @covers \MiW\Results\Entity\Result::getResult
     * @return void
     */
    public function testResult(): void
    {
       $this->assertInstanceOf(Result::class, self::$result);
    }

    /**
     * Implement testUser().
     *
     * @covers \MiW\Results\Entity\Result::setUser()
     * @covers \MiW\Results\Entity\Result::getUser()
     * @return void
     */
    public function testUser(): void
    {
        $this->assertInstanceOf(User::class, self::$user);
    }

    /**
     * Implement testTime().
     *
     * @covers \MiW\Results\Entity\Result::setTime
     * @covers \MiW\Results\Entity\Result::getTime
     * @return void
     */
    public function testTime(): void
    {
        self::assertNotEquals("00:00:00 :",self::$time);
    }
   /**
     * Implement testTo_String().
     *
     * @covers \MiW\Results\Entity\Result::__toString
     * @return void
     */
    public function testToString(): void
    {
        $result = new Result();
        self::assertEquals(true, method_exists($result, '__toString'));
    }

    /**
     * Implement testJson_Serialize().
     *
     * @covers \MiW\Results\Entity\Result::jsonSerialize
     * @return void
     */
    public function testJsonSerialize(): void
    {
        $result = new Result(1,null,((new \DateTime())));
        self::assertJson(json_encode($result, JSON_PRETTY_PRINT));
    }
}
