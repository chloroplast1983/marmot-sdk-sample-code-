<?php
namespace UserGroup\Utils;

use UserGroup\Model\UserGroup;

class ObjectGenerate
{
    public static function generateUserGroup(int $id = 0, int $seed = 0, array $value = array()) : UserGroup
    {
        $faker = \Faker\Factory::create('zh_CN');
        $faker->seed($seed);

        $userGroup = new UserGroup($id);

        //name
        $name = isset($value['name']) ? $value['name'] : $faker->name();
        $userGroup->setName($name);
       
        $userGroup->setCreateTime($faker->unixTime());
        $userGroup->setUpdateTime($faker->unixTime());
        $userGroup->setStatusTime($faker->unixTime());
        //status
        $status = isset($value['status']) ? $value['status'] : $faker->randomElement(
            $array = array(
                UserGroup::STATUS_NORMAL,
                UserGroup::STATUS_DELETE
            )
        );

        $userGroup->setStatus($status);

        return $userGroup;
    }
}
