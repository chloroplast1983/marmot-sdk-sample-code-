<?php
namespace Sample\Sdk\Common\Adapter;

use Sample\Sdk\Common\Model\IOperatAble;

interface IOperatAbleAdapter
{
    public function add(IOperatAble $operatAbleObject) : bool;

    public function edit(IOperatAble $operatAbleObject) : bool;
}
