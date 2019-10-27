<?php
namespace Sample\Sdk\News\Adapter\News;

use Prophecy\Argument;
use PHPUnit\Framework\TestCase;

use Marmot\Interfaces\IRestfulTranslator;

use Sample\Sdk\News\Model\News;
use Sample\Sdk\News\Model\NullNews;
use Sample\Sdk\News\Utils\ObjectGenerate;
use Sample\Sdk\News\Translator\NewsRestfulTranslator;

class NewsRestfulAdapterTest extends TestCase
{
    private $stub;
    
    private $childStub;

    public function setUp()
    {
        $this->stub = $this->getMockBuilder(NewsRestfulAdapter::class)
            ->setMethods([
                'fetchOneAction',
                'isSuccess',
                'post',
                'patch',
                'translateToObject',
                'getTranslator'
            ])
            ->getMock();

        $this->childStub = new class extends NewsRestfulAdapter
        {
            public function getResource() : string
            {
                return parent::getResource();
            }

            public function getTranslator() : IRestfulTranslator
            {
                return parent::getTranslator();
            }

            public function getScenario() : array
            {
                return parent::getScenario();
            }
        };
    }

    public function tearDown()
    {
        unset($this->stub);
        unset($this->childStub);
    }

    public function testImplementsINewsAdapter()
    {
        $this->assertInstanceOf(
            'Sample\Sdk\News\Adapter\News\INewsAdapter',
            $this->stub
        );
    }

    public function testGetResource()
    {
        $this->assertEquals('news', $this->childStub->getResource());
    }

    public function testGetTranslator()
    {
        $this->assertInstanceOf(
            'Marmot\Interfaces\IRestfulTranslator',
            $this->childStub->getTranslator()
        );
    }

    /**
     * @dataProvider scenarioDataProvider
     */
    public function testScenario($expect, $actural)
    {
        $this->childStub->scenario($expect);
        $this->assertEquals($actural, $this->childStub->getScenario());
    }

    public function scenarioDataProvider()
    {
        return [
            ['NEWS_LIST', NewsRestfulAdapter::SCENARIOS['NEWS_LIST']],
            ['NEWS_FETCH_ONE', NewsRestfulAdapter::SCENARIOS['NEWS_FETCH_ONE']],
            ['NULL', array()]
        ];
    }

    public function testFetchOne()
    {
        $id = 1;

        $news = ObjectGenerate::generateNews($id);

        $this->stub->expects($this->exactly(1))
                   ->method('fetchOneAction')
                   ->with($id, new NullNews())
                   ->willReturn($news);

        $result = $this->stub->fetchOne($id);
        $this->assertEquals($news, $result);
    }

    private function prepareNewsTranslator(News $news, array $keys, array $newsArray)
    {
        $translator = $this->prophesize(NewsRestfulTranslator::class);
        $translator->objectToArray(
            Argument::exact($news),
            Argument::exact($keys)
        )->shouldBeCalledTimes(1)
        ->willReturn($newsArray);

        $this->stub->expects($this->exactly(1))
                   ->method('getTranslator')
                   ->willReturn($translator->reveal());
    }

    private function success(News $news)
    {
        $this->stub->expects($this->exactly(1))
                   ->method('isSuccess')
                   ->willReturn(true);
        $this->stub->expects($this->exactly(1))
                    ->method('translateToObject')
                    ->with($news);
    }

    private function failure()
    {
        $this->stub->expects($this->exactly(1))
                   ->method('isSuccess')
                   ->willReturn(false);
        $this->stub->expects($this->exactly(0))
                    ->method('translateToObject');
    }

    public function testAddSuccess()
    {
        $news = ObjectGenerate::generateNews(1);
        $newsArray = array('news');
        
        $this->prepareNewsTranslator(
            $news,
            array('title', 'source', 'content', 'image', 'attachments', 'publishUserGroup'),
            $newsArray
        );

        $this->stub->expects($this->exactly(1))
                   ->method('post')
                   ->with('news', $newsArray);

        $this->success($news);
        $result = $this->stub->add($news);
        $this->assertTrue($result);
    }
    
    public function testAddFailure()
    {
        $news = ObjectGenerate::generateNews(1);
        $newsArray = array('news');
        
        $this->prepareNewsTranslator(
            $news,
            array('title', 'source', 'content', 'image', 'attachments', 'publishUserGroup'),
            $newsArray
        );

        $this->stub->expects($this->exactly(1))
                   ->method('post')
                   ->with('news', $newsArray);

        $this->failure($news);
        $result = $this->stub->add($news);
        $this->assertFalse($result);
    }

    public function testEditSuccess()
    {
        $news = ObjectGenerate::generateNews(1);
        $newsArray = array('news');
        
        $this->prepareNewsTranslator(
            $news,
            array('title', 'source', 'content', 'image', 'attachments'),
            $newsArray
        );

        $this->stub->expects($this->exactly(1))
                   ->method('patch')
                   ->with('news/'.$news->getId(), $newsArray);

        $this->success($news);
        $result = $this->stub->edit($news);
        $this->assertTrue($result);
    }

    public function testEditFailure()
    {
        $news = ObjectGenerate::generateNews(1);
        $newsArray = array('news');
        
        $this->prepareNewsTranslator(
            $news,
            array('title', 'source', 'content', 'image', 'attachments'),
            $newsArray
        );

        $this->stub->expects($this->exactly(1))
                   ->method('patch')
                   ->with('news/'.$news->getId(), $newsArray);

        $this->failure($news);
        $result = $this->stub->edit($news);
        $this->assertFalse($result);
    }
}
