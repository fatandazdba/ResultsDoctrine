<?php
/**
 * PHP version 7.2
 * tests/Entity/UserTest.php
 *
 * @category EntityTests
 * @package  MiW\Results\Tests
 * @author   Javier Gil <franciscojavier.gil@upm.es>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://www.etsisi.upm.es ETS de Ingeniería de Sistemas Informáticos
 */

namespace MiW\Results\Tests\Entity;
use MiW\Results\Utils;
use MiW\Results\Entity\Result;

use MiW\Results\Entity\User;
use PHPUnit\Framework\TestCase;

/**
 * Class UserTest
 *
 * @package MiW\Results\Tests\Entity
 * @group   users
 */
class UserTest extends TestCase
{
    /**
     * @var User $user
     */
    protected static $user;
    protected static $entityManager;
    protected static $userRepository;
    protected static $var_alea;
    /**
     * Sets up the fixture.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        // fwrite(STDOUT, __METHOD__ . "\n");
        self::$var_alea=random_int(1,1000);
        self::$user = new User('freddy_'.self::$var_alea, "freddy@gmail.com_".self::$var_alea, "123456",true, false);

        self::$entityManager = Utils::getEntityManager();
        self::$entityManager->persist(self::$user);
        self::$entityManager->flush();

        self::$userRepository = self::$entityManager->getRepository(User::class);
    }

    /**
     * @covers \MiW\Results\Entity\User::__construct()
     */
    public function testConstructor(): void
    {
        $this->assertEquals("freddy@gmail.com_".self::$var_alea,self::$user->getEmail());
    }

    /**
     * @covers \MiW\Results\Entity\User::getId()
     */
    public function testGetId(): void
    {
        self::assertNotEquals(100,self::$userRepository->find(1));
    }

    /**
     * @covers \MiW\Results\Entity\User::setUsername()
     * @covers \MiW\Results\Entity\User::getUsername()
     */
    public function testGetSetUsername(): void
    {
        self::assertEquals('freddy_'.self::$var_alea, self::$user->getUsername());
        self::$user->setUsername('fatandaz_'.self::$var_alea);
        self::assertEquals('fatandaz_'.self::$var_alea, self::$user->getUsername());
    }

    /**
     * @covers \MiW\Results\Entity\User::getEmail()
     * @covers \MiW\Results\Entity\User::setEmail()
     */
    public function testGetSetEmail(): void
    {
        self::assertEquals('freddy@gmail.com_'.self::$var_alea, self::$user->getEmail());
        self::$user->setEmail('fatandaz@alumnos.upm.es_'.self::$var_alea);
        self::assertEquals('fatandaz@alumnos.upm.es_'.self::$var_alea, self::$user->getEmail());
    }

    /**
     * @covers \MiW\Results\Entity\User::setEnabled()
     * @covers \MiW\Results\Entity\User::isEnabled()
     */
    public function testIsSetEnabled(): void
    {
        self::$user->setEnabled(false);
        self::assertEquals(false,self::$user->isEnabled());
    }

    /**
     * @covers \MiW\Results\Entity\User::setIsAdmin()
     * @covers \MiW\Results\Entity\User::isAdmin
     */
    public function testIsSetAdmin(): void
    {
        self::$user->setIsAdmin(true);
        self::assertEquals(true,self::$user->isAdmin());
    }

    /**
     * @covers \MiW\Results\Entity\User::setPassword()
     * @covers \MiW\Results\Entity\User::validatePassword()
     */
    public function testSetValidatePassword(): void
    {
        $userVeri = new User();
        $this->$userVeri = self::$userRepository->find(1);
        self::assertEquals(false,self::$user->validatePassword($this->$userVeri->getPassword()));
    }

    /**
     * @covers \MiW\Results\Entity\User::__toString()
     */
    public function testToString(): void
    {
        $userVeri = new User();
        self::assertEquals(true, method_exists($userVeri, '__toString'));
    }

    /**
     * @covers \MiW\Results\Entity\User::jsonSerialize()
     */
    public function testJsonSerialize(): void
    {
        $user = new User("freddy", "freddy@gmail.com", "123456",true, false);
        self::assertJson(json_encode($user, JSON_PRETTY_PRINT));
    }
}
