<?php
namespace Sample\Sdk\News\Translator;

use Marmot\Interfaces\IRestfulTranslator;

use Sample\Sdk\Common\Translator\RestfulTranslatorTrait;

use Sample\Sdk\News\Model\News;
use Sample\Sdk\News\Model\NullNews;

use Sample\Sdk\UserGroup\Translator\UserGroupRestfulTranslator;

class NewsRestfulTranslator implements IRestfulTranslator
{
    use RestfulTranslatorTrait;

    protected function getUserGroupRestfulTranslator() : UserGroupRestfulTranslator
    {
        return new UserGroupRestfulTranslator();
    }

    public function arrayToObject(array $expression, $news = null)
    {
        return $this->translateToObject($expression, $news);
    }

    /**
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    protected function translateToObject(array $expression, $news = null)
    {
        if (empty($expression)) {
            return new NullNews();
        }

        if ($news == null) {
            $news = new News();
        }

        $data =  $expression['data'];

        $id = $data['id'];
        $news->setId($id);

        $attributes = isset($data['attributes']) ? $data['attributes'] : '';

        if (isset($attributes['title'])) {
            $news->setTitle($attributes['title']);
        }
        if (isset($attributes['source'])) {
             $news->setSource($attributes['source']);
        }
        if (isset($attributes['content'])) {
            $news->setContent($attributes['content']);
        }
        if (isset($attributes['image'])) {
            $news->setImage($attributes['image']);
        }
        if (isset($attributes['attachments'])) {
            $news->setAttachments($attributes['attachments']);
        }
        if (isset($attributes['createTime'])) {
            $news->setCreateTime($attributes['createTime']);
        }
        if (isset($attributes['updateTime'])) {
            $news->setUpdateTime($attributes['updateTime']);
        }
        if (isset($attributes['status'])) {
            $news->setStatus($attributes['status']);
        }
        if (isset($attributes['statusTime'])) {
            $news->setStatusTime($attributes['statusTime']);
        }

        $relationships = isset($data['relationships']) ? $data['relationships'] : array();

        if (isset($expression['included'])) {
            $relationships = $this->relationship($expression['included'], $relationships);
        }

        if (isset($relationships['publishUserGroup']['data'])) {
            $userGroup = $this->changeArrayFormat($relationships['publishUserGroup']['data']);
            $news->setPublishUserGroup($this->getUserGroupRestfulTranslator()->arrayToObject($userGroup));
        }

        return $news;
    }

    /**
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function objectToArray($news, array $keys = array())
    {
        if (!$news instanceof News) {
            return array();
        }

        if (empty($keys)) {
            $keys = array(
                'id',
                'title',
                'source',
                'content',
                'image',
                'attachments',
                'publishUserGroup'
            );
        }

        $expression = array(
            'data'=>array(
                'type'=>'news'
            )
        );
        
        if (in_array('id', $keys)) {
            $expression['data']['id'] = $news->getId();
        }

        $attributes = array();

        if (in_array('title', $keys)) {
            $attributes['title'] = $news->getTitle();
        }
        if (in_array('source', $keys)) {
            $attributes['source'] = $news->getSource();
        }
        if (in_array('content', $keys)) {
            $attributes['content'] = $news->getContent();
        }
        if (in_array('image', $keys)) {
            $attributes['image'] = $news->getImage();
        }
        if (in_array('attachments', $keys)) {
            $attributes['attachments'] = $news->getAttachments();
        }

        $expression['data']['attributes'] = $attributes;

        if (in_array('publishUserGroup', $keys)) {
            $expression['data']['relationships']['publishUserGroup']['data'] = array(
                array(
                    'type' => 'userGroups',
                    'id' => $news->getPublishUserGroup()->getId()
                )
             );
        }

        return $expression;
    }
}
