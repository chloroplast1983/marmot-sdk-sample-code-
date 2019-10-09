<?php
namespace Sample\Sdk\Common\Model;

use Sample\Sdk\Common\Adapter\IOperatAbleAdapter;

trait OperatAbleTrait
{
    public function add() : bool
    {
        $repository = $this->getIOperatAbleAdapter();

        return $repository->add($this);
    }

    public function edit() : bool
    {
        $repository = $this->getIOperatAbleAdapter();

        return $repository->edit($this);
    }

    abstract protected function getIOperatAbleAdapter() : IOperatAbleAdapter;
}
