<?php
namespace Common\Model;

trait NullOperatAbleTrait
{
    public function add() : bool
    {
        return $this->resourceNotExist();
    }

    public function edit() : bool
    {
        return $this->resourceNotExist();
    }
}
