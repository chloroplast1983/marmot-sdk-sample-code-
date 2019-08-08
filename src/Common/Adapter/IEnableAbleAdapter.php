<?php
namespace Common\Adapter;

use Common\Model\IEnableAble;

interface IEnableAbleAdapter
{
    public function enable(IEnableAble $enableAbleObject) : bool;

    public function disable(IEnableAble $enableAbleObject) : bool;
}
