<?php
namespace Sample\Sdk\News\Translator;

use Prophecy\Argument;
use PHPUnit\Framework\TestCase;

use Sample\Sdk\News\Model\News;
use Sample\Sdk\News\Utils\ArrayGenerate;
use Sample\Sdk\News\Utils\ObjectGenerate;

use Sample\Sdk\UserGroup\Model\UserGroup;
use Sample\Sdk\UserGroup\Translator\UserGroupRestfulTranslator;

class NewsRestfulTranslatorTest extends TestCase
{
    private $translator;
    private $childTranslator;

    public function setUp()
    {
        $this->translator = $this->getMockBuilder(NewsRestfulTranslator::class)
            ->setMethods(['getUserGroupRestfulTranslator'])
            ->getMock();

        $this->childTranslator = new class extends NewsRestfulTranslator
        {
            public function getUserGroupRestfulTranslator() : UserGroupRestfulTranslator
            {
                return parent::getUserGroupRestfulTranslator();
            }
        };
        parent::setUp();
    }

    public function testGetUserGroupRestfulTranslator()
    {
        $this->assertInstanceOf(
            'Sample\Sdk\UserGroup\Translator\UserGroupRestfulTranslator',
            $this->childTranslator->getUserGroupRestfulTranslator()
        );
    }

    public function testArrayToObjectIncorrectObject()
    {
        $result = $this->translator->arrayToObject(array(), new News());
        $this->assertInstanceOf('Sample\Sdk\News\Model\NullNews', $result);
    }

    public function testArrayToObjectCorrectObject()
    {
        $news = ArrayGenerate::generateNews();

        $data =  $news['data'];
        $relationships = $data['relationships'];

        $userGroup = new UserGroup($relationships['publishUserGroup']['data']['id']);
        $userGroupRestfulTranslator = $this->prophesize(UserGroupRestfulTranslator::class);
        $userGroupRestfulTranslator->arrayToObject(
            Argument::exact($relationships['publishUserGroup'])
        )->shouldBeCalledTimes(1)->willReturn($userGroup);
        $this->translator->expects($this->exactly(1))
            ->method('getUserGroupRestfulTranslator')
            ->willReturn($userGroupRestfulTranslator->reveal());

        $actual = $this->translator->arrayToObject($news);

        $expectObject = $this->fetchNews($data);

        $this->assertEquals($expectObject, $actual);
    }

    public function testArrayToObjects()
    {
        $result = $this->translator->arrayToObjects(array());
        $this->assertEquals(array(0,array()), $result);
    }

    public function testArrayToObjectsOneCorrectObject()
    {
        $news = ArrayGenerate::generateNews();
        $data =  $news['data'];
        $relationships = $data['relationships'];

        $userGroup = new UserGroup($relationships['publishUserGroup']['data']['id']);
        $userGroupRestfulTranslator = $this->prophesize(UserGroupRestfulTranslator::class);
        $userGroupRestfulTranslator->arrayToObject(
            Argument::exact($relationships['publishUserGroup'])
        )->shouldBeCalledTimes(1)->willReturn($userGroup);
        $this->translator->expects($this->exactly(1))
            ->method('getUserGroupRestfulTranslator')
            ->willReturn($userGroupRestfulTranslator->reveal());

        $actual = $this->translator->arrayToObjects($news);
        $expectArray = array();

        $expectObject = $this->fetchNews($data);

        $expectArray = [1, [$data['id']=>$expectObject]];

        $this->assertEquals($expectArray, $actual);
    }

    public function testArrayToObjectsCorrectObject()
    {
        $news[] = ArrayGenerate::generateNews(1);
        $news[] = ArrayGenerate::generateNews(2);

        $newsArray= array('data'=>array(
            $news[0]['data'],
            $news[1]['data']
        ));

        $expectArray = array();
        $results = array();

        foreach ($newsArray['data'] as $each) {
            $data =  $each;
            $expectObject = $this->fetchNews($data);
            $results[$data['id']] = $expectObject;
        }

        $userGroupRestfulTranslator = $this->prophesize(UserGroupRestfulTranslator::class);

        $userGroup = new UserGroup($newsArray['data'][0]['relationships']['publishUserGroup']['data']['id']);
        $userGroupRestfulTranslator->arrayToObject(
            Argument::exact(
                $newsArray['data'][0]['relationships']['publishUserGroup']
            )
        )->shouldBeCalledTimes(1)->willReturn($userGroup);

        $userGroup1 = new UserGroup($newsArray['data'][1]['relationships']['publishUserGroup']['data']['id']);
        $userGroupRestfulTranslator->arrayToObject(
            Argument::exact(
                $newsArray['data'][1]['relationships']['publishUserGroup']
            )
        )->shouldBeCalledTimes(1)->willReturn($userGroup1);

        $this->translator->expects($this->exactly(2))
            ->method('getUserGroupRestfulTranslator')
            ->willReturn($userGroupRestfulTranslator->reveal());

        $actual = $this->translator->arrayToObjects($newsArray);

        $expectArray = [2, $results];

        $this->assertEquals($expectArray, $actual);
    }

    protected function fetchNews($data) : News
    {
        $relationships = $data['relationships'];

        $expectObject = new News();

        $expectObject->setId($data['id']);

        $attributes = isset($data['attributes']) ? $data['attributes'] : '';
        if (isset($attributes['title'])) {
            $expectObject->setTitle($attributes['title']);
        }
        if (isset($attributes['source'])) {
            $expectObject->setSource($attributes['source']);
        }
        if (isset($attributes['content'])) {
            $expectObject->setContent($attributes['content']);
        }
        if (isset($attributes['image'])) {
            $expectObject->setImage($attributes['image']);
        }
        if (isset($attributes['attachments'])) {
            $expectObject->setAttachments($attributes['attachments']);
        }
        if (isset($attributes['createTime'])) {
            $expectObject->setCreateTime($attributes['createTime']);
        }
        if (isset($attributes['updateTime'])) {
            $expectObject->setUpdateTime($attributes['updateTime']);
        }
        if (isset($attributes['status'])) {
            $expectObject->setStatus($attributes['status']);
        }
        if (isset($attributes['statusTime'])) {
            $expectObject->setStatusTime($attributes['statusTime']);
        }
        if (isset($relationships['publishUserGroup']['data'])) {
            $expectObject->setPublishUserGroup(new UserGroup($relationships['publishUserGroup']['data']['id']));
        }

        return $expectObject;
    }

    /**
     * 如果传参错误对象, 期望返回空数组
     */
    public function testObjectToArrayIncorrectObject()
    {
        $result = $this->translator->objectToArray(null);
        $this->assertEquals(array(), $result);
    }
    /**
     * 传参正确对象, 返回对应数组
     */
    public function testObjectToArrayCorrectObject()
    {
        $news = ObjectGenerate::generateNews(1, 1);

        $actual = $this->translator->objectToArray($news);

        $expectedArray = array(
            'data'=>array(
                'type'=>'news',
                'id'=>$news->getId()
            )
        );

        $expectedArray['data']['attributes'] = array(
            'title'=>$news->getTitle(),
            'source'=>$news->getSource(),
            'content'=>$news->getContent(),
            'image'=>$news->getImage(),
            'attachments'=>$news->getAttachments(),
        );

        $expectedArray['data']['relationships']['publishUserGroup']['data'] = array(
            array(
                'type' => 'userGroups',
                'id' => $news->getPublishUserGroup()->getId()
            )
        );

        $this->assertEquals($expectedArray, $actual);
    }
}
