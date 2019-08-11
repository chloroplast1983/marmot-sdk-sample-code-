<?php
namespace Sdk\UserGroup\Translator;

use PHPUnit\Framework\TestCase;

use Sdk\UserGroup\Model\UserGroup;
use Sdk\UserGroup\Utils\ArrayGenerate;
use Sdk\UserGroup\Utils\ObjectGenerate;
use Sdk\UserGroup\Translator\UserGroupRestfulTranslator;

class UserGroupRestfulTranslatorTest extends TestCase
{
    private $translator;

    public function setUp()
    {
        $this->translator = new UserGroupRestfulTranslator();
    }

    public function testArrayToObjectIncorrectObject()
    {
        $result = $this->translator->arrayToObject(array(), new UserGroup());
        $this->assertInstanceOf('Sdk\UserGroup\Model\NullUserGroup', $result);
    }

    public function testArrayToObjectCorrectObject()
    {
        $userGroup = ArrayGenerate::generateUserGroup();

        $data = $userGroup['data'];

        $actual = $this->translator->arrayToObject($userGroup);

        $expectObject = $this->fetchUserGroup($data);

        $this->assertEquals($expectObject, $actual);
    }

    public function testArrayToObjects()
    {
        $result = $this->translator->arrayToObjects(array());
        $this->assertEquals(array(0,array()), $result);
    }

    public function testArrayToObjectsOneCorrectObject()
    {
        $userGroup = ArrayGenerate::generateUserGroup();

        $data =  $userGroup['data'];

        $actual = $this->translator->arrayToObjects($userGroup);

        $expectObject = $this->fetchUserGroup($data);

        $expectArray = [1, [$data['id']=>$expectObject]];

        $this->assertEquals($expectArray, $actual);
    }

    public function testArrayToObjectsCorrectObject()
    {
        $userGroup[] = ArrayGenerate::generateUserGroup(5);
        $userGroup[] = ArrayGenerate::generateUserGroup(6);

        $userGroupArray= array('data'=>array(
            $userGroup[0]['data'],
            $userGroup[1]['data']
        ));

        $expectArray = array();
        $results = array();

        foreach ($userGroupArray['data'] as $each) {
            $data = $each;

            $expectObject = $this->fetchUserGroup($data);
            $results[$data['id']] = $expectObject;
        }

        $actual = $this->translator->arrayToObjects($userGroupArray);

        $expectArray = [2, $results];

        $this->assertEquals($expectArray, $actual);
    }

    protected function fetchUserGroup($data) : UserGroup
    {
        $expectObject = new UserGroup();

        $expectObject->setId($data['id']);

        $attributes = $data['attributes'];
        if (isset($attributes['name'])) {
            $expectObject->setName($attributes['name']);
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
        $userGroup = ObjectGenerate::generateUserGroup(1, 1);

        $actual = $this->translator->objectToArray($userGroup);

        $expectArray = array(
            'data'=>array(
                'type'=>'userGroups',
                'id'=>$userGroup->getId()
            )
        );

        $expectArray['data']['attributes'] = array(
            'name'=>$userGroup->getName()
        );

        $this->assertEquals($expectArray, $actual);
    }
}
