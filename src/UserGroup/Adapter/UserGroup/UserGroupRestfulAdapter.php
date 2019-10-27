<?php
namespace Sample\Sdk\UserGroup\Adapter\UserGroup;

use Marmot\Core;
use Marmot\Interfaces\IRestfulTranslator;
use Marmot\Framework\Adapter\Restful\GuzzleAdapter;

use Sample\Sdk\Common\Adapter\FetchAbleRestfulAdapterTrait;
use Sample\Sdk\Common\Adapter\AsyncFetchAbleRestfulAdapterTrait;

use Sample\Sdk\UserGroup\Model\NullUserGroup;
use Sample\Sdk\UserGroup\Translator\UserGroupRestfulTranslator;

class UserGroupRestfulAdapter extends GuzzleAdapter implements IUserGroupAdapter
{
    use AsyncFetchAbleRestfulAdapterTrait, FetchAbleRestfulAdapterTrait;

    private $translator;
    private $resource;

    const SCENARIOS = [
        'USERGROUP_LIST'=>[
            'fields'=>['userGroups'=>'id,name,updateTime,status']
        ],
        'USERGROUP_FETCH_ONE'=>[
            'fields'=>[]
        ]
    ];
    
    public function __construct(string $uri = '', array $authKey = [])
    {
        parent::__construct(
            $uri,
            $authKey
        );
        $this->translator = new UserGroupRestfulTranslator();
        $this->scenario = array();
        $this->resource = 'userGroups';
    }

    protected function getTranslator() : IRestfulTranslator
    {
        return $this->translator;
    }

    public function scenario($scenario) : void
    {
        $this->scenario = isset(self::SCENARIOS[$scenario]) ? self::SCENARIOS[$scenario] : array();
    }

    protected function getResource() : string
    {
        return $this->resource;
    }

    public function fetchOne($id)
    {
        return $this->fetchOneAction($id, new NullUserGroup());
    }
}
