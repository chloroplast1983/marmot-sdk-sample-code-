<?php
namespace Sample\Sdk\Common\Model;

use Sample\Sdk\Common\Adapter\IOperatAbleAdapter;

class MockOperatAbleTrait implements IOperatAble
{
    use OperatAbleTrait;

    protected function getIOperatAbleAdapter() : IOperatAbleAdapter
    {
        $class = new class implements IOperatAbleAdapter
        {
            public function add() : bool
            {
                return false;
            }
            
            public function edit() : bool
            {
                return false;
            }
        };

        return $class;
    }
}
