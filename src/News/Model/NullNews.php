<?php
namespace Sample\Sdk\News\Model;

use Marmot\Core;
use Marmot\Interfaces\INull;

use Sample\Sdk\Common\Model\NullOperatAbleTrait;
use Sample\Sdk\Common\Model\NullEnableAbleTrait;

class NullNews extends News implements INull
{
    use NullOperatAbleTrait, NullEnableAbleTrait;
    
    private static $instance;
    
    public static function &getInstance()
    {
        if (!self::$instance instanceof self) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    protected function resourceNotExist() : bool
    {
        Core::setLastError(RESOURCE_NOT_EXIST);
        return false;
    }
}
