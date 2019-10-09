<?php
namespace Sample\Sdk\Common\Repository;

use Sample\Sdk\Common\Model\IEnableAble;

trait EnableAbleRepositoryTrait
{
    public function enable(IEnableAble $enableAbleObject) : bool
    {
        return $this->getAdapter()->enable($enableAbleObject);
    }

    public function disable(IEnableAble $enableAbleObject) : bool
    {
        return $this->getAdapter()->disable($enableAbleObject);
    }
}
