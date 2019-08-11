<?php
namespace Sdk\News\Adapter\News;

use Marmot\Core;
use Marmot\Framework\Interfaces\IRestfulTranslator;
use Marmot\Framework\Adapter\Restful\GuzzleAdapter;

use Sdk\Common\Adapter\EnableAbleRestfulAdapterTrait;
use Sdk\Common\Adapter\FetchAbleRestfulAdapterTrait;
use Sdk\Common\Adapter\OperatAbleRestfulAdapterTrait;
use Sdk\Common\Adapter\AsyncFetchAbleRestfulAdapterTrait;

use Sdk\News\Model\News;
use Sdk\News\Model\NullNews;
use Sdk\News\Translator\NewsRestfulTranslator;

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
    
    public function __construct()
    {
        parent::__construct(
            Core::$container->get('services.backend.url')
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
