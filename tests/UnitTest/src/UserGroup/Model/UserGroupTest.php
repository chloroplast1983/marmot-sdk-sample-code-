<?php
namespace Sdk\UserGroup\Model;

use PHPUnit\Framework\TestCase;

class UserGroupTest extends TestCase
{
    private $stub;

    public function setUp()
    {
        $this->stub = new UserGroup();
    }

    public function tearDown()
    {
        unset($stub);
    }

    public function testCorrectImplementsIObject()
    {
        $this->assertInstanceof('Marmot\Common\Model\IObject', $this->stub);
    }

    /**
     * UserGroup 单位领域对象,测试构造函数
     */
    public function testUserGroupConstructor()
    {
        $this->assertEmpty($this->stub->getName());
        $this->assertEquals(0, $this->stub->getId());
        $this->assertEquals(0, $this->stub->getStatus());
        $this->assertEquals(0, $this->stub->getCreateTime());
        $this->assertEquals(0, $this->stub->getUpdateTime());
        $this->assertEquals(0, $this->stub->getStatusTime());
    }

    //id 测试 ---------------------------------------------------------- start
    /**
     * 设置 UserGroup setId() 正确的传参类型,期望传值正确
     */
    public function testSetIdCorrectType()
    {
        $this->stub->setId(1);
        $this->assertEquals(1, $this->stub->getId());
    }

    /**
     * 设置 UserGroup setId() 错误的传参类型.但是传参是数值,期望返回类型正确,值正确.
     */
    public function testSetIdWrongTypeButNumeric()
    {
        $this->stub->setId('1');
        $this->assertTrue(is_int($this->stub->getId()));
        $this->assertEquals(1, $this->stub->getId());
    }
    //id 测试 ----------------------------------------------------------   end

    //name 测试 -------------------------------------------------------- start
    /**
     * 设置 UserGroup setName() 正确的传参类型,期望传值正确
     */
    public function testSetNameCorrectType()
    {
        $this->stub->setName('string');
        $this->assertEquals('string', $this->stub->getName());
    }

    /**
     * 设置 UserGroup setName() 错误的传参类型,期望期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testSetNameWrongType()
    {
        $this->stub->setName(array(1,2,3));
    }
    //name 测试 --------------------------------------------------------   end
}
