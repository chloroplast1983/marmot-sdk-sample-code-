<?php
namespace Common\Adapter;

use PHPUnit\Framework\TestCase;

class FetchAbleRestfulAdapterTraitTest extends TestCase
{
    private $stub;

    public function setUp()
    {
        $this->stub = $this->getMockBuilder(TestFetchAbleRestfulAdapter::class)
            ->setMethods(
                [
                    'get',
                    'translateToObjects',
                    'isSuccess',
                ]
            )->getMock();
    }

    public function tearDown()
    {
        unset($this->stub);
    }

    public function testFetchListSuccess()
    {
        $ids = array(1,2,3);
        $news = array(
                \News\Utils\ObjectGenerate::generateNews(1),
                \News\Utils\ObjectGenerate::generateNews(2),
                \News\Utils\ObjectGenerate::generateNews(3),
            );

        $newsArray = array(
            \News\Utils\ArrayGenerate::generateNews(1),
            \News\Utils\ArrayGenerate::generateNews(2),
            \News\Utils\ArrayGenerate::generateNews(3),
        );

        $this->stub->expects($this->exactly(1))
            ->method('get')
            ->with('news/'.implode(',', $ids))
            ->willReturn($newsArray);

        $this->stub->expects($this->exactly(1))
            ->method('isSuccess')
            ->willReturn(true);

        $this->stub->expects($this->exactly(1))
            ->method('translateToObjects')
            ->willReturn($news);

        $result = $this->stub->fetchList($ids);
        $this->assertEquals($news, $result);
    }

    public function testFetchListActionFailure()
    {
        $ids = array(1,2,3);

        $newsArray = array(
            \News\Utils\ArrayGenerate::generateNews(1),
            \News\Utils\ArrayGenerate::generateNews(2),
            \News\Utils\ArrayGenerate::generateNews(3),
        );

        $this->stub->expects($this->exactly(1))
            ->method('get')
            ->with('news/'.implode(',', $ids))
            ->willReturn($newsArray);

        $this->stub->expects($this->exactly(1))
            ->method('isSuccess')
            ->willReturn(false);

        $this->stub->expects($this->exactly(0))
            ->method('translateToObjects');

        $result = $this->stub->fetchList($ids);
        $this->assertEquals(array(0, array()), $result);
    }

    public function testSearchSuccess()
    {
        $filter = array();
        $sort = array();
        $page = 0;
        $size = 10;
        $news = array(
            \News\Utils\ObjectGenerate::generateNews(1),
            \News\Utils\ObjectGenerate::generateNews(2),
            \News\Utils\ObjectGenerate::generateNews(3),
        );

        $newsArray = array(
            \News\Utils\ArrayGenerate::generateNews(1),
            \News\Utils\ArrayGenerate::generateNews(2),
            \News\Utils\ArrayGenerate::generateNews(3),
        );

        $this->stub->expects($this->exactly(1))
            ->method('get')
            ->with('news')
            ->willReturn($newsArray);

        $this->stub->expects($this->exactly(1))
            ->method('isSuccess')
            ->willReturn(true);

        $this->stub->expects($this->exactly(1))
            ->method('translateToObjects')
            ->willReturn($news);

        $result = $this->stub->search($filter, $sort, $page, $size);
        $this->assertEquals($news, $result);
    }

    public function testSearchActionFailure()
    {
        $filter = array();
        $sort = array();
        $page = 0;
        $size = 10;

        $newsArray = array(
            \News\Utils\ArrayGenerate::generateNews(1),
            \News\Utils\ArrayGenerate::generateNews(2),
            \News\Utils\ArrayGenerate::generateNews(3),
        );

        $this->stub->expects($this->exactly(1))
            ->method('get')
            ->with('news')
            ->willReturn($newsArray);

        $this->stub->expects($this->exactly(1))
            ->method('isSuccess')
            ->willReturn(false);

        $this->stub->expects($this->exactly(0))
            ->method('translateToObjects');

        $result = $this->stub->search($filter, $sort, $page, $size);
        $this->assertEquals(array(0,array()), $result);
    }
}
