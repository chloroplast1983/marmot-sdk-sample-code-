<?php
namespace Sample\Sdk\UserGroup\Repository;

use Prophecy\Argument;
use PHPUnit\Framework\TestCase;

use Sample\Sdk\UserGroup\Adapter\UserGroup\UserGroupRestfulAdapter;

class UserGroupRepositoryTest extends TestCase
{
    private $stub;

    private $childStub;

    public function setUp()
    {
        $this->stub = $this->getMockBuilder(UserGroupRepository::class)
                    ->setMethods(['getAdapter'])
                    ->getMock();

        $this->childStub = new class extends UserGroupRepository
        {
            public function getAdapter() : UserGroupRestfulAdapter
            {
                return parent::getAdapter();
            }
        };
    }

    public function tearDown()
    {
        unset($this->stub);
        unset($this->childStub);
    }

    public function testGetAdapter()
    {
        $this->assertInstanceOf(
            'Sample\Sdk\UserGroup\Adapter\UserGroup\UserGroupRestfulAdapter',
            $this->childStub->getAdapter()
        );
    }

    public function testScenario()
    {
        $adapter = $this->prophesize(UserGroupRestfulAdapter::class);
        $adapter->scenario(Argument::exact(UserGroupRepository::LIST_MODEL_UN))->shouldBeCalledTimes(1);
        $this->stub->expects($this->exactly(1))
            ->method('getAdapter')
            ->willReturn($adapter->reveal());
            
        $result = $this->stub->scenario(UserGroupRepository::LIST_MODEL_UN);
        $this->assertEquals($this->stub, $result);
    }
}
