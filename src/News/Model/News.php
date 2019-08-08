<?php
namespace News\Model;

use Marmot\Core;
use Marmot\Common\Model\Object;
use Marmot\Common\Model\IObject;

use Common\Model\IEnableAble;
use Common\Model\IOperatAble;
use Common\Model\EnableAbleTrait;
use Common\Model\OperatAbleTrait;
use Common\Adapter\IEnableAbleAdapter;
use Common\Adapter\IOperatAbleAdapter;

use UserGroup\Model\UserGroup;

use News\Repository\NewsRepository;

class News implements IEnableAble, IOperatAble, IObject
{
    use EnableAbleTrait, OperatAbleTrait, Object;

    private $id;

    private $title;

    private $source;

    private $content;

    private $attachments;

    private $image;

    private $publishUserGroup;

    private $repository;

    public function __construct(int $id = 0)
    {
        $this->id = !empty($id) ? $id : 0;
        $this->title = '';
        $this->source = '';
        $this->content = '';
        $this->attachments = array();
        $this->image = array();
        $this->publishUserGroup = Core::$container->has('user')
            ? Core::$container->get('user')->getUserGroup() : new UserGroup();
        $this->statusTime = 0;
        $this->createTime = 0;
        $this->updateTime = 0;
        $this->status = IEnableAble::STATUS['ENABLED'];
        $this->repository = new NewsRepository();
    }

    public function __destruct()
    {
        unset($this->id);
        unset($this->title);
        unset($this->content);
        unset($this->createTime);
        unset($this->updateTime);
        unset($this->statusTime);
        unset($this->status);
        unset($this->source);
        unset($this->attachments);
        unset($this->image);
        unset($this->publishUserGroup);
        unset($this->repository);
    }

    public function setId($id) : void
    {
        $this->id = $id;
    }

    public function getId() : int
    {
        return $this->id;
    }

    public function setTitle(string $title) : void
    {
        $this->title = $title;
    }

    public function getTitle() : string
    {
        return $this->title;
    }

    public function setContent(string $content) : void
    {
        $this->content = $content;
    }

    public function getContent() : string
    {
        return $this->content;
    }

    public function setSource(string $source) : void
    {
        $this->source = $source;
    }

    public function getSource() : string
    {
        return $this->source;
    }

    public function setAttachments(array $attachments) : void
    {
        $this->attachments = $attachments;
    }

    public function getAttachments() : array
    {
        return $this->attachments;
    }

    public function setImage(array $image) : void
    {
        $this->image = $image;
    }

    public function getImage() : array
    {
        return $this->image;
    }

    public function setPublishUserGroup(UserGroup $publishUserGroup) : void
    {
        $this->publishUserGroup = $publishUserGroup;
    }

    public function getPublishUserGroup() : UserGroup
    {
        return $this->publishUserGroup;
    }

    protected function getRepository() : NewsRepository
    {
        return $this->repository;
    }

    protected function getIEnableAbleAdapter() : IEnableAbleAdapter
    {
        return $this->getRepository();
    }

    protected function getIOperatAbleAdapter() : IOperatAbleAdapter
    {
        return $this->getRepository();
    }
}
