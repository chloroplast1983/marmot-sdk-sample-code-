<?php
namespace Common\Model;

class MockNullEnableAbleTrait
{
    use NullEnableAbleTrait;

    protected function resourceNotExist() : bool
    {
        return false;
    }
}
