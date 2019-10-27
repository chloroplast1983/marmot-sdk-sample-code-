<?php
namespace Sample\Sdk\UserGroup\Repository;

use Sample\Sdk\Common\Repository\AsyncRepositoryTrait;
use Sample\Sdk\Common\Repository\FetchRepositoryTrait;
use Sample\Sdk\Common\Repository\ErrorRepositoryTrait;

use Sample\Sdk\UserGroup\Adapter\UserGroup\IUserGroupAdapter;
use Sample\Sdk\UserGroup\Adapter\UserGroup\UserGroupRestfulAdapter;

use Marmot\Core;

class UserGroupRepository implements IUserGroupAdapter
{
    use FetchRepositoryTrait, AsyncRepositoryTrait, ErrorRepositoryTrait;

    private $adapter;

    const LIST_MODEL_UN = 'USERGROUP_LIST';
    const FETCH_ONE_MODEL_UN = 'USERGROUP__FETCH_ONE';

    public function __construct(string $uri = '', array $authKey = [])
    {
        $this->adapter = new UserGroupRestfulAdapter(
            Core::$container->has('sdk.url') ? Core::$container->get('sdk.url') : ’‘,
            Core::$container->has('sdk.authKey') ? Core::$container->get('sdk.authKey') : ’‘
        );
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
