<?php
namespace Sample\Sdk\Common\Repository;

use Sample\Sdk\Common\Model\IOperatAble;

trait OperatAbleRepositoryTrait
{
    public function add(IOperatAble $operatAbleObject) : bool
    {
        return $this->getAdapter()->add($operatAbleObject);
    }

    public function edit(IOperatAble $operatAbleObject) : bool
    {
        return $this->getAdapter()->edit($operatAbleObject);
    }
}
