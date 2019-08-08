<?php
namespace Common\Adapter;

use News\Translator\NewsRestfulTranslator;
use Common\Model\IEnableAble;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

class EnableAbleRestfulAdapterTraitTest extends TestCase
{
    private $stub;

    public function setUp()
    {
        $this->stub = $this->getMockBuilder(TestEnableAbleRestfulAdapter::class)
            ->setMethods(
                [
                    'patch',
                    'isSuccess',
                    'translateToObject',
                    'getTranslator'
                ]
            )->getMock();
    }

    public function tearDown()
    {
        unset($this->stub);
    }

    private function success(IEnableAble $enableAbleObject)
    {
        $this->stub->expects($this->exactly(1))
            ->method('isSuccess')
            ->willReturn(true);
        $this->stub->expects($this->exactly(1))
            ->method('translateToObject')
            ->with($enableAbleObject);
    }

    private function failure()
    {
        $this->stub->expects($this->exactly(1))
            ->method('isSuccess')
            ->willReturn(false);
        $this->stub->expects($this->exactly(0))
            ->method('translateToObject');
    }

    public function testEnableSuccess()
    {
        $news = \News\Utils\ObjectGenerate::generateNews(1);

        $url = 'news/'.$news->getId().'/enable';

        $this->stub->expects($this->exactly(1))
            ->method('patch')
            ->with($url);

        $this->success($news);

        $result = $this->stub->enable($news);
        $this->assertTrue($result);
    }
    
    public function testEnableFailure()
    {
        $news = \News\Utils\ObjectGenerate::generateNews(1);

        $url = 'news/'.$news->getId().'/enable';

        $this->stub->expects($this->exactly(1))
            ->method('patch')
            ->with($url);

        $this->failure($news);
        $result = $this->stub->enable($news);
        $this->assertFalse($result);
    }

    public function testDisableSuccess()
    {
        $news = \News\Utils\ObjectGenerate::generateNews(1);

        $url = 'news/'.$news->getId().'/disable';

        $this->stub->expects($this->exactly(1))
            ->method('patch')
            ->with($url);

        $this->success($news);

        $result = $this->stub->disable($news);
        $this->assertTrue($result);
    }

    public function testDisableFailure()
    {
        $news = \News\Utils\ObjectGenerate::generateNews(1);

        $url = 'news/'.$news->getId().'/disable';

        $this->stub->expects($this->exactly(1))
            ->method('patch')
            ->with($url);

        $this->failure($news);
        $result = $this->stub->disable($news);
        $this->assertFalse($result);
    }
}
