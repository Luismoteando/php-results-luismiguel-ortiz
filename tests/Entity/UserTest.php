<?php
/**
 * PHP version 7.3
 * tests/Entity/UserTest.php
 *
 * @category EntityTests
 * @package  MiW\Results\Tests
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://www.etsisi.upm.es/ ETS de Ingeniería de Sistemas Informáticos
 */

namespace MiW\Results\Tests\Entity;

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
    private $user;

    private const USERNAME = 'uSeR ñ¿?Ñ';
    private const EMAIL = self::USERNAME . '@' . self::USERNAME . '.com';
    private const PASSWORD = 'uSeR ñ¿?Ñ';

    /**
     * Sets up the fixture.
     * This method is called before a test is executed.
     */
    protected function setUp(): void
    {
        $this->user = new User(
            self::USERNAME,
            self::EMAIL,
            self::PASSWORD,
            true,
            false
        );
    }

    /**
     * @covers \MiW\Results\Entity\User::__construct()
     */
    public function testConstructor(): void
    {
        $this->user = new User(
            self::USERNAME,
            self::EMAIL,
            self::PASSWORD,
            true,
            false
        );
        self::assertEquals(self::USERNAME, $this->user->getUsername());
        self::assertEquals(self::EMAIL, $this->user->getEmail());
        self::assertEquals(true, $this->user->isEnabled());
        self::assertEquals(false, $this->user->isAdmin());
    }

    /**
     * @covers \MiW\Results\Entity\User::getId()
     */
    public function testGetId(): void
    {
        self::assertIsNumeric(
            $this->user->getId()
        );
    }

    /**
     * @covers \MiW\Results\Entity\User::setUsername()
     * @covers \MiW\Results\Entity\User::getUsername()
     */
    public function testGetSetUsername(): void
    {
        $this->user->setUsername(self::USERNAME);
        self::assertEquals(
            self::USERNAME,
            $this->user->getUsername()
        );
    }

    /**
     * @covers \MiW\Results\Entity\User::getEmail()
     * @covers \MiW\Results\Entity\User::setEmail()
     */
    public function testGetSetEmail(): void
    {
        $this->user->setEmail(self::EMAIL);
        self::assertEquals(
            self::EMAIL,
            $this->user->getEmail()
        );
    }

    /**
     * @covers \MiW\Results\Entity\User::setEnabled()
     * @covers \MiW\Results\Entity\User::isEnabled()
     */
    public function testIsSetEnabled(): void
    {
        $this->user->setEnabled(true);
        self::assertEquals(
            true,
            $this->user->isEnabled()
        );
    }

    /**
     * @covers \MiW\Results\Entity\User::setIsAdmin()
     * @covers \MiW\Results\Entity\User::isAdmin
     */
    public function testIsSetAdmin(): void
    {
        $this->user->setIsAdmin(false);
        self::assertEquals(
            false,
            $this->user->isAdmin()
        );
    }

    /**
     * @covers \MiW\Results\Entity\User::setPassword()
     * @covers \MiW\Results\Entity\User::validatePassword()
     */
    public function testSetValidatePassword(): void
    {
        $this->user->setPassword(self::PASSWORD);
        self::assertTrue(
            $this->user->validatePassword(self::PASSWORD)
        );
    }

    /**
     * @covers \MiW\Results\Entity\User::__toString()
     */
    public function testToString(): void
    {
        $vars = get_object_vars($this->user);
        self::assertEmpty($vars, $this->user->__toString());
    }

    /**
     * @covers \MiW\Results\Entity\User::jsonSerialize()
     */
    public function testJsonSerialize(): void
    {
        $json = json_encode(
            $this->user->jsonSerialize()
        );
        self::assertJson($json);
    }
}
