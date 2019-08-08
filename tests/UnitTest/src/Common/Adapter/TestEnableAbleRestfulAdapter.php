<?php
namespace Common\Adapter;

class TestEnableAbleRestfulAdapter
{
    use EnableAbleRestfulAdapterTrait;

    protected function getResource()
    {
        return 'news';
    }
}
