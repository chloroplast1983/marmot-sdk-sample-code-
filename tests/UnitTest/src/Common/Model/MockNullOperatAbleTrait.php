<?php
namespace Sample\Sdk\Common\Model;

class MockNullOperatAbleTrait
{
    use NullOperatAbleTrait;

    protected function resourceNotExist() : bool
    {
        return false;
    }
}
