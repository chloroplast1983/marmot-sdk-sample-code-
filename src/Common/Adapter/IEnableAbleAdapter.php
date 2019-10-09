<?php
namespace Sample\Sdk\Common\Adapter;

use Sample\Sdk\Common\Model\IEnableAble;

interface IEnableAbleAdapter
{
    public function enable(IEnableAble $enableAbleObject) : bool;

    public function disable(IEnableAble $enableAbleObject) : bool;
}
