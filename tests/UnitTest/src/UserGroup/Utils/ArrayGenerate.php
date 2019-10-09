<?php
namespace Sample\Sdk\UserGroup\Utils;

use Sample\Sdk\UserGroup\Model\UserGroup;

class ArrayGenerate
{
    public static function generateUserGroup(int $seed = 0) : array
    {
        $faker = \Faker\Factory::create('zh_CN');
        $faker->seed($seed);

        $userGroup = array();

        $userGroup = array(
            'data'=>array(
                'type'=>'userGroups',
                'id'=>$faker->randomNumber(2)
            )
        );

        $attributes = array();

        //name
        $name = isset($value['name']) ? $value['name'] : $faker->sentence();
        $attributes['name'] = $name;
       
        //createTime
        $createTime = isset($value['createTime']) ? $value['createTime'] : 1513737146;
        $attributes['createTime'] = $createTime;

        //updateTime
        $updateTime = isset($value['updateTime']) ? $value['updateTime'] : 1513737146;
        $attributes['updateTime'] = $updateTime;

        //statusTime
        $statusTime = isset($value['statusTime']) ? $value['statusTime'] : 1513737146;
        $attributes['statusTime'] = $statusTime;

        //status
        $status = isset($value['status']) ? $value['status'] : $faker->randomElement(
            $array = array(
                UserGroup::STATUS_DELETE,
                UserGroup::STATUS_NORMAL
            )
        );
        $attributes['status'] = $status;

        $userGroup['data']['attributes'] = $attributes;

        return $userGroup;
    }
}
