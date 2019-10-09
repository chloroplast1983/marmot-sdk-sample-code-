<?php
namespace Sample\Sdk\Common\Adapter;

use Sample\Sdk\Common\Model\IOperatAble;

trait OperatAbleRestfulAdapterTrait
{
    abstract protected function addAction(IOperatAble $enableAbleObject) : bool;
    abstract protected function editAction(IOperatAble $enableAbleObject) : bool;

    public function add(IOperatAble $enableAbleObject) : bool
    {
        return $this->addAction($enableAbleObject);
    }

    public function edit(IOperatAble $enableAbleObject) : bool
    {
        return $this->editAction($enableAbleObject);
    }
}
