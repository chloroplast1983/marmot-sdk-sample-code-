<?php
namespace Sample\Sdk\UserGroup\Translator;

use Sample\Sdk\Common\Translator\RestfulTranslatorTrait;

use Marmot\Interfaces\IRestfulTranslator;

use Sample\Sdk\UserGroup\Model\UserGroup;
use Sample\Sdk\UserGroup\Model\NullUserGroup;

class UserGroupRestfulTranslator implements IRestfulTranslator
{
    use RestfulTranslatorTrait;

    public function arrayToObject(array $expression, $userGroup = null)
    {
        return $this->translateToObject($expression, $userGroup);
    }

    protected function translateToObject(array $expression, $userGroup = null)
    {
        if (empty($expression)) {
            return new NullUserGroup();
        }

        if ($userGroup == null) {
            $userGroup = new UserGroup();
        }

        $data = $expression['data'];

        $id = $data['id'];
        $userGroup->setId($id);

        if (isset($data['attributes'])) {
            $attributes = $data['attributes'];

            if (isset($attributes['name'])) {
                $userGroup->setName($attributes['name']);
            }
            if (isset($attributes['createTime'])) {
                $userGroup->setCreateTime($attributes['createTime']);
            }
            if (isset($attributes['updateTime'])) {
                $userGroup->setUpdateTime($attributes['updateTime']);
            }
            if (isset($attributes['status'])) {
                $userGroup->setStatus($attributes['status']);
            }
            if (isset($attributes['statusTime'])) {
                $userGroup->setStatusTime($attributes['statusTime']);
            }
        }

        return $userGroup;
    }

    public function objectToArray($userGroup, array $keys = array())
    {
        if (!$userGroup instanceof UserGroup) {
            return array();
        }

        if (empty($keys)) {
            $keys = array(
                'id',
                'name',
            );
        }

        $expression = array(
            'data'=>array(
                'type'=>'userGroups'
            )
        );
        
        if (in_array('id', $keys)) {
            $expression['data']['id'] = $userGroup->getId();
        }

        $attributes = array();
        if (in_array('name', $keys)) {
            $attributes['name'] = $userGroup->getName();
        }
        
        $expression['data']['attributes'] = $attributes;
        
        return $expression;
    }
}
