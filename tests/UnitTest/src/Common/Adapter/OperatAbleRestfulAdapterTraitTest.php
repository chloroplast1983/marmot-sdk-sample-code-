<?php
namespace Common\Adapter;

use PHPUnit\Framework\TestCase;

class OperatAbleRestfulAdapterTraitTest extends TestCase
{
    private $stub;

    public function setUp()
    {
        $this->stub = $this->getMockForTrait(OperatAbleRestfulAdapterTrait::class);
    }

    public function tearDown()
    {
        unset($this->stub);
    }

    public function testAdd()
    {
        $news = \News\Utils\ObjectGenerate::generateNews(1);

        $this->stub->expects($this->any())
             ->method('addAction')
             ->with($news)
             ->will($this->returnValue(true));

        $this->assertTrue($this->stub->add($news));
    }

    public function testEdit()
    {
        $news = \News\Utils\ObjectGenerate::generateNews(1);

        $this->stub->expects($this->any())
             ->method('editAction')
             ->with($news)
             ->will($this->returnValue(true));

        $this->assertTrue($this->stub->edit($news));
    }
}
