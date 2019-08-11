<?php
namespace Sdk\UserGroup\Repository\UserGroup;

use Sdk\Common\Repository\AsyncRepositoryTrait;
use Sdk\Common\Repository\FetchRepositoryTrait;

use Sdk\UserGroup\Adapter\UserGroup\IUserGroupAdapter;
use Sdk\UserGroup\Adapter\UserGroup\UserGroupRestfulAdapter;

class UserGroupRepository implements IUserGroupAdapter
{
    use FetchRepositoryTrait, AsyncRepositoryTrait;

    private $adapter;

    const LIST_MODEL_UN = 'USERGROUP_LIST';
    const FETCH_ONE_MODEL_UN = 'USERGROUP__FETCH_ONE';

    public function __construct()
    {
        $this->adapter = new UserGroupRestfulAdapter();
    }

    public function scenario($scenario)
    {
        $this->getAdapter()->scenario($scenario);
        return $this;
    }

    protected function getAdapter()
    {
        return $this->adapter;
    }
}
