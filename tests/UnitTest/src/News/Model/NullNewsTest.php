<?php
namespace Sdk\News\Model;

use Marmot\Core;

use PHPUnit\Framework\TestCase;

class NullNewsTest extends TestCase
{
    private $stub;

    public function setUp()
    {
        $this->stub = NullNews::getInstance();
        Core::setLastError(ERROR_NOT_DEFINED);
    }

    public function tearDown()
    {
        unset($this->stub);
        Core::setLastError(ERROR_NOT_DEFINED);
    }

    public function testExtendsNews()
    {
        $this->assertInstanceof('Sdk\News\Model\News', $this->stub);
    }

    public function testImplementsNull()
    {
        $this->assertInstanceof('Marmot\Framework\Interfaces\INull', $this->stub);
    }

    public function testAdd()
    {
        $result = $this->stub->add();
        $this->assertFalse($result);
        $this->assertEquals(RESOURCE_NOT_EXIST, Core::getLastError()->getId());
    }

    public function testEdit()
    {
        $result = $this->stub->edit();
        $this->assertFalse($result);
        $this->assertEquals(RESOURCE_NOT_EXIST, Core::getLastError()->getId());
    }

    public function testEnable()
    {
        $result = $this->stub->enable();
        $this->assertFalse($result);
        $this->assertEquals(RESOURCE_NOT_EXIST, Core::getLastError()->getId());
    }

    public function testDisable()
    {
        $result = $this->stub->disable();
        $this->assertFalse($result);
        $this->assertEquals(RESOURCE_NOT_EXIST, Core::getLastError()->getId());
    }
}
