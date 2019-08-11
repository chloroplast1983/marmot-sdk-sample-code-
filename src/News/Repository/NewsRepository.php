<?php
namespace Sdk\News\Repository;

use Sdk\Common\Repository\AsyncRepositoryTrait;
use Sdk\Common\Repository\FetchRepositoryTrait;
use Sdk\Common\Repository\EnableAbleRepositoryTrait;
use Sdk\Common\Repository\OperatAbleRepositoryTrait;

use Sdk\News\Adapter\News\INewsAdapter;
use Sdk\News\Adapter\News\NewsRestfulAdapter;

class NewsRepository implements INewsAdapter
{
    use FetchRepositoryTrait, AsyncRepositoryTrait, EnableAbleRepositoryTrait, OperatAbleRepositoryTrait;

    private $adapter;

    const LIST_MODEL_UN = 'NEWS_LIST';
    const FETCH_ONE_MODEL_UN = 'NEWS_FETCH_ONE';

    public function __construct()
    {
        $this->adapter = new NewsRestfulAdapter();
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
