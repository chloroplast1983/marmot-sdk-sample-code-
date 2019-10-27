<?php
namespace Sample\Sdk\News\Adapter\News;

use Marmot\Core;
use Marmot\Interfaces\IRestfulTranslator;
use Marmot\Framework\Adapter\Restful\GuzzleAdapter;

use Sample\Sdk\Common\Adapter\EnableAbleRestfulAdapterTrait;
use Sample\Sdk\Common\Adapter\FetchAbleRestfulAdapterTrait;
use Sample\Sdk\Common\Adapter\OperatAbleRestfulAdapterTrait;
use Sample\Sdk\Common\Adapter\AsyncFetchAbleRestfulAdapterTrait;

use Sample\Sdk\News\Model\News;
use Sample\Sdk\News\Model\NullNews;
use Sample\Sdk\News\Translator\NewsRestfulTranslator;

class NewsRestfulAdapter extends GuzzleAdapter implements INewsAdapter
{
    use FetchAbleRestfulAdapterTrait,
        EnableAbleRestfulAdapterTrait,
        OperatAbleRestfulAdapterTrait,
        AsyncFetchAbleRestfulAdapterTrait;

    private $translator;

    private $resource;

    const SCENARIOS = [
        'NEWS_LIST'=>[
            'fields'=>[
                'news'=>'title,source,updateTime,status,publishUserGroup',
                'userGroups'=>'name'
            ],
            'include'=>'publishUserGroup'
        ],
        'NEWS_FETCH_ONE'=>[
            'fields'=>['userGroups'=>'name'],
            'include'=>'publishUserGroup'
        ]
    ];
    
    public function __construct(string $uri = '', array $authKey = [])
    {
        parent::__construct(
            $uri,
            $authKey
        );
        $this->translator = new NewsRestfulTranslator();
        $this->resource = 'news';
        $this->scenario = array();
    }

    protected function getTranslator() : IRestfulTranslator
    {
        return $this->translator;
    }

    protected function getResource() : string
    {
        return $this->resource;
    }

    public function scenario($scenario) : void
    {
        $this->scenario = isset(self::SCENARIOS[$scenario]) ? self::SCENARIOS[$scenario] : array();
    }

    public function fetchOne($id)
    {
        return $this->fetchOneAction($id, new NullNews());
    }

    protected function addAction(News $news) : bool
    {
        $data = $this->getTranslator()->objectToArray(
            $news,
            array('title', 'source', 'content', 'image', 'attachments', 'publishUserGroup')
        );
        
        $this->post(
            $this->getResource(),
            $data
        );
        
        if ($this->isSuccess()) {
            $this->translateToObject($news);
            return true;
        }

        return false;
    }

    protected function editAction(News $news) : bool
    {
        $data = $this->getTranslator()->objectToArray(
            $news,
            array('title', 'source', 'content', 'image', 'attachments')
        );

        $this->patch(
            $this->getResource().'/'.$news->getId(),
            $data
        );

        if ($this->isSuccess()) {
            $this->translateToObject($news);
            return true;
        }

        return false;
    }
}
