<?php
namespace News\Model;

use Marmot\Core;
use Marmot\Framework\Interfaces\INull;

use Common\Model\NullOperatAbleTrait;
use Common\Model\NullEnableAbleTrait;

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
