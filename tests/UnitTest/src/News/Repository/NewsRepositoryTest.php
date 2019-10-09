<?php
namespace Sample\Sdk\News\Repository;

use Prophecy\Argument;
use PHPUnit\Framework\TestCase;

use Sample\Sdk\News\Adapter\News\NewsRestfulAdapter;

class NewsRepositoryTest extends TestCase
{
    private $stub;
    private $childStub;

    public function setUp()
    {
        $this->stub = $this->getMockBuilder(NewsRepository::class)
            ->setMethods(['getAdapter'])
            ->getMock();

        $this->childStub = new class extends NewsRepository {
            public function getAdapter() : NewsRestfulAdapter
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
            'Sample\Sdk\News\Adapter\News\NewsRestfulAdapter',
            $this->childStub->getAdapter()
        );
    }

    public function testScenario()
    {
        $adapter = $this->prophesize(NewsRestfulAdapter::class);
        $adapter->scenario(Argument::exact(NewsRepository::LIST_MODEL_UN))->shouldBeCalledTimes(1);
        $this->stub->expects($this->exactly(1))
            ->method('getAdapter')
            ->willReturn($adapter->reveal());
            
        $result = $this->stub->scenario(NewsRepository::LIST_MODEL_UN);
        $this->assertEquals($this->stub, $result);
    }
}
