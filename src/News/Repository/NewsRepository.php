<?php
namespace Sample\Sdk\News\Repository;

use Sample\Sdk\Common\Repository\AsyncRepositoryTrait;
use Sample\Sdk\Common\Repository\FetchRepositoryTrait;
use Sample\Sdk\Common\Repository\EnableAbleRepositoryTrait;
use Sample\Sdk\Common\Repository\OperatAbleRepositoryTrait;
use Sample\Sdk\Common\Repository\ErrorRepositoryTrait;

use Sample\Sdk\News\Adapter\News\INewsAdapter;
use Sample\Sdk\News\Adapter\News\NewsRestfulAdapter;

class NewsRepository implements INewsAdapter
{
    use FetchRepositoryTrait, AsyncRepositoryTrait, EnableAbleRepositoryTrait, OperatAbleRepositoryTrait, ErrorRepositoryTrait;

    private $adapter;

    const LIST_MODEL_UN = 'NEWS_LIST';
    const FETCH_ONE_MODEL_UN = 'NEWS_FETCH_ONE';

    public function __construct(string $uri, array $authKey)
    {
        $this->adapter = new NewsRestfulAdapter(
            $uri,
            $authKey
        );
    }

    protected function getAdapter() : NewsRestfulAdapter
    {
        return $this->adapter;
    }

    public function scenario($scenario)
    {
        $this->getAdapter()->scenario($scenario);
        return $this;
    }
}
