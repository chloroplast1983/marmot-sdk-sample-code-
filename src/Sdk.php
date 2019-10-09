<?php
namespace Sample\Sdk;

use Marmot\Framework\Interfaces\ISdk;

use Sample\Sdk\News\Adapter\News\INewsAdapter;
use Sample\Sdk\UserGroup\Adapter\UserGroup\IUserGroupAdapter;

use Sample\Sdk\News\Repository\NewsRepository;
use Sample\Sdk\UserGroup\Repository\UserGroupRepository;

class Sdk implements ISdk
{
    private $uri;

    private $authKey;

    private $newsRepository;

    private $userGroupResitory;

    public function __construct(string $uri, array $authKey)
    {
        $this->uri = $uri;
        $this->authKey = $authKey;
        $this->newsRepository = new NewsRepository($uri, $authKey);
        $this->userGroupResitory = new UserGroupRepository($uri, $authKey);
    }

    public function __destruct()
    {
        unset($this->uri);
        unset($this->authKey);
        unset($this->newsRepository);
        unset($this->userGroupResitory);
    }

    public function getUri() : string
    {
        return $this->uri;
    }

    public function getAuthKey() : array
    {
        return $this->authKey;
    }

    public function newsRepository() : INewsAdapter
    {
        return $this->newsRepository;
    }

    public function userGroupResitory() : IUserGroupAdapter
    {
        return $this->userGroupResitory;
    }
}
