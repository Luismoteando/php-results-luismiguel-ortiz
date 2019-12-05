<?php
/**
 * PHP version 7.3
 * tests/Entity/ResultTest.php
 *
 * @category EntityTests
 * @package  MiW\Results\Tests
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://www.etsisi.upm.es/ ETS de Ingeniería de Sistemas Informáticos
 */

namespace MiW\Results\Tests\Entity;

use DateTime;
use Exception;
use MiW\Results\Entity\Result;
use MiW\Results\Entity\User;
use PHPUnit\Framework\TestCase;

/**
 * Class ResultTest
 *
 * @package MiW\Results\Tests\Entity
 */
class ResultTest extends TestCase
{
    /**
     * @var User $user
     */
    private $user;

    /**
     * @var Result $result
     */
    private $result;

    private const USERNAME = 'uSeR ñ¿?Ñ';
    private const POINTS = 2018;

    /**
     * @var DateTime $time
     */
    private $time;

    /**
     * Sets up the fixture.
     * This method is called before a test is executed.
     *
     * @return void
     * @throws Exception
     */
    protected function setUp(): void
    {
        $this->user = new User();
        $this->user->setUsername(self::USERNAME);
        $this->time = new DateTime('now');
        $this->result = new Result(
            self::POINTS,
            $this->user,
            $this->time
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
        $result = new Result(
            self::POINTS,
            $this->user,
            $this->time
        );
        self::assertEquals(self::POINTS, $result->getResult());
        self::assertEquals(self::POINTS, $result->getResult());
        self::assertEquals($this->user, $result->getUser());
        self::assertEquals($this->time, $result->getTime());
    }

    /**
     * Implement testGet_Id().
     *
     * @covers \MiW\Results\Entity\Result::getId()
     * @return void
     */
    public function testGetId(): void
    {
        self::assertIsNumeric(
            $this->result->getId()
        );
    }

    /**
     * Implement testResult().
     *
     * @covers \MiW\Results\Entity\Result::setResult
     * @covers \MiW\Results\Entity\Result::getResult
     * @return void
     */
    public function testResult(): void
    {
        $this->result->setResult(self::POINTS);
        self::assertEquals(
            self::POINTS,
            $this->result->getResult()
        );
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
        $this->result->setUser($this->user);
        self::assertEquals(
            $this->user,
            $this->result->getUser()
        );
    }

    /**
     * Implement testTime().
     *
     * @covers \MiW\Results\Entity\Result::setTime
     * @covers \MiW\Results\Entity\Result::getTime
     * @return void
     * @throws Exception
     */
    public function testTime(): void
    {
        $this->result->setTime($this->time);
        self::assertEquals(
            $this->time,
            $this->result->getTime()
        );
    }

    /**
     * Implement testTo_String().
     *
     * @covers \MiW\Results\Entity\Result::__toString
     * @return void
     */
    public function testToString(): void
    {
        $vars = get_object_vars($this->result);
        self::assertEmpty($vars, $this->result->__toString());
    }

    /**
     * Implement testJson_Serialize().
     *
     * @covers \MiW\Results\Entity\Result::jsonSerialize
     * @return void
     */
    public function testJsonSerialize(): void
    {
        $json = json_encode(
            $this->result->jsonSerialize()
        );
        self::assertJson($json);
    }
}
