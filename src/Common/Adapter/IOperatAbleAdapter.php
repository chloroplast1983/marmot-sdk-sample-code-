<?php
namespace Common\Adapter;

use Common\Model\IOperatAble;

interface IOperatAbleAdapter
{
    public function add(IOperatAble $operatAbleObject) : bool;

    public function edit(IOperatAble $operatAbleObject) : bool;
}
