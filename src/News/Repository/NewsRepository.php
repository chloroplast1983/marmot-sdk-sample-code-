<?php
namespace News\Repository;

use Common\Repository\AsyncRepositoryTrait;
use Common\Repository\FetchRepositoryTrait;
use Common\Repository\EnableAbleRepositoryTrait;
use Common\Repository\OperatAbleRepositoryTrait;

use News\Adapter\News\INewsAdapter;
use News\Adapter\News\NewsRestfulAdapter;
use News\Model\News;

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
