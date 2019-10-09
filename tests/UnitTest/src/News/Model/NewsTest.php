<?php
namespace Sample\Sdk\News\Model;

use Prophecy\Argument;
use PHPUnit\Framework\TestCase;

use Sample\Sdk\News\Repository\NewsRepository;

use Sample\Sdk\Common\Model\IEnableAble;
use Sample\Sdk\Common\Adapter\IEnableAbleAdapter;
use Sample\Sdk\Common\Adapter\IOperatAbleAdapter;

use Sample\Sdk\UserGroup\Model\UserGroup;

class NewsTest extends TestCase
{
    private $stub;
    
    private $childStub;

    public function setUp()
    {
        $this->stub = $this->getMockBuilder(News::class)
            ->setMethods([
                'getRepository',
                'getIEnableAbleAdapter',
                'getIOperatAbleAdapter'
            ])
            ->getMock();

        $this->childStub = new class extends News
        {
            public function getRepository(): NewsRepository
            {
                return parent::getRepository();
            }

            public function getIEnableAbleAdapter(): IEnableAbleAdapter
            {
                return parent::getIEnableAbleAdapter();
            }

            public function getIOperatAbleAdapter() : IOperatAbleAdapter
            {
                return parent::getIOperatAbleAdapter();
            }
        };
    }

    public function tearDown()
    {
        unset($this->stub);
        unset($this->childStub);
    }

    /**
     * News 新闻类,测试构造函数
     */
    public function testNewsConstructor()
    {
        $this->assertEquals(0, $this->stub->getId());
        $this->assertEmpty($this->stub->getTitle());
        $this->assertEmpty($this->stub->getSource());
        $this->assertEmpty($this->stub->getContent());
        $this->assertEquals(array(), $this->stub->getAttachments());
        $this->assertEquals(array(), $this->stub->getImage());
        $this->assertEquals(IEnableAble::STATUS['ENABLED'], $this->stub->getStatus());
        $this->assertEquals(0, $this->stub->getCreateTime());
        $this->assertEquals(0, $this->stub->getUpdateTime());
        $this->assertEquals(0, $this->stub->getStatusTime());
        $this->assertInstanceof('Sample\Sdk\UserGroup\Model\UserGroup', $this->stub->getPublishUserGroup());
    }

    public function testCorrectImplementsIEnableAble()
    {
        $this->assertInstanceof('Sample\Sdk\Common\Model\IEnableAble', $this->stub);
    }

    public function testCorrectImplementsIOperatAble()
    {
        $this->assertInstanceof('Sample\Sdk\Common\Model\IOperatAble', $this->stub);
    }

    public function testCorrectImplementsIObject()
    {
        $this->assertInstanceof('Marmot\Common\Model\IObject', $this->stub);
    }

    //id 测试 ---------------------------------------------------------- start
    /**
     * 设置 News setId() 正确的传参类型,期望传值正确
     */
    public function testSetIdCorrectType()
    {
        $this->stub->setId(1);
        $this->assertEquals(1, $this->stub->getId());
    }

    /**
     * 设置 News setId() 错误的传参类型.但是传参是数值,期望返回类型正确,值正确.
     */
    public function testSetIdWrongTypeButNumeric()
    {
        $this->stub->setId('1');
        $this->assertTrue(is_int($this->stub->getId()));
        $this->assertEquals(1, $this->stub->getId());
    }
    //id 测试 ----------------------------------------------------------   end

    //title 测试 ------------------------------------------------------- start
    /**
     * 设置 News setTitle() 正确的传参类型,期望传值正确
     */
    public function testSetTitleCorrectType()
    {
        $this->stub->setTitle('string');
        $this->assertEquals('string', $this->stub->getTitle());
    }

    /**
     * 设置 News setTitle() 错误的传参类型,期望期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testSetTitleWrongType()
    {
        $this->stub->setTitle(array(1, 2, 3));
    }
    //title 测试 -------------------------------------------------------   end

    //source 测试 ------------------------------------------------------ start
    /**
     * 设置 Journal setSource() 正确的传参类型,期望传值正确
     */
    public function testSetSourceCorrectType()
    {
        $this->stub->setSource('string');
        $this->assertEquals('string', $this->stub->getSource());
    }

    /**
     * 设置 Journal setSource() 错误的传参类型,期望期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testSetSourceWrongType()
    {
        $this->stub->setSource(array(1, 2, 3));
    }
    //source 测试 ------------------------------------------------------   end

    //content 测试 ----------------------------------------------------- start
    /**
     * 设置 News setContent() 正确的传参类型,期望传值正确
     */
    public function testSetContentCorrectType()
    {
        $this->stub->setContent('string');
        $this->assertEquals('string', $this->stub->getContent());
    }

    /**
     * 设置 News setContent() 错误的传参类型,期望期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testSetContentWrongType()
    {
        $this->stub->setContent(array(1, 2, 3));
    }
    //content 测试 -----------------------------------------------------   end

    //attachments 测试 ------------------------------------------------- start
    public function testSetAttachmentsCorrectType()
    {
        $this->stub->setAttachments(array(1, 2, 3));
        $this->assertEquals(array(1, 2, 3), $this->stub->getAttachments());
    }

    /**
     * @expectedException TypeError
     */
    public function testSetAttachmentsWrongType()
    {
        $this->stub->setAttachments(1);
    }
    //attachments 测试 -------------------------------------------------   end

    //image 测试 ------------------------------------------------------ start
    public function testSetImageCorrectType()
    {
        $this->stub->setImage(array('image'));
        $this->assertEquals(array('image'), $this->stub->getImage());
    }

    /**
     * @expectedException TypeError
     */
    public function testSetImageWrongType()
    {
        $this->stub->setImage('string');
    }
    //image 测试 ------------------------------------------------------   end

    //publishUserGroup 测试 --------------------------------------------- start
    /**
     * 设置 News setPublishUserGroup() 正确的传参类型,期望传值正确
     */
    public function testSetPublishUserGroupCorrectType()
    {
        $object = new UserGroup();
        $this->stub->setPublishUserGroup($object);
        $this->assertSame($object, $this->stub->getPublishUserGroup());
    }

    /**
     * 设置 News setPublishUserGroup() 错误的传参类型,期望期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testSetPublishUserGroupWrongType()
    {
        $this->stub->setPublishUserGroup('string');
    }
    //publishUserGroup 测试 ---------------------------------------------   end

    public function testGetRepository()
    {
        $this->assertInstanceOf(
            'Sample\Sdk\News\Repository\NewsRepository',
            $this->childStub->getRepository()
        );
    }

    public function testGetIEnableAbleAdapter()
    {
        $this->assertInstanceOf(
            'Sample\Sdk\Common\Adapter\IEnableAbleAdapter',
            $this->childStub->getIEnableAbleAdapter()
        );
    }

    public function testGetIOperatAbleAdapter()
    {
        $this->assertInstanceOf(
            'Sample\Sdk\Common\Adapter\IOperatAbleAdapter',
            $this->childStub->getIOperatAbleAdapter()
        );
    }
}
