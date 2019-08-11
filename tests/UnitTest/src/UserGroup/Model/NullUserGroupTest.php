<?php
namespace Sdk\UserGroup\Model;

use PHPUnit\Framework\TestCase;

class NullUserGroupTest extends TestCase
{
    private $stub;

    public function setUp()
    {
        $this->stub = NullUserGroup::getInstance();
    }

    public function tearDown()
    {
        unset($this->stub);
    }

    public function testExtendsUserGroup()
    {
        $this->assertInstanceof('Sdk\UserGroup\Model\UserGroup', $this->stub);
    }

    public function testImplementsNull()
    {
        $this->assertInstanceof('Marmot\Framework\Interfaces\INull', $this->stub);
    }
}
