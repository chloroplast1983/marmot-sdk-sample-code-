<?php
namespace Common\Repository;

use Common\Model\IEnableAble;

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
