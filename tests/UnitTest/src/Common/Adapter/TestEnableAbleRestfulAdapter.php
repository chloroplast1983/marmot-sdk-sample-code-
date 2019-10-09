<?php
namespace Sample\Sdk\Common\Adapter;

class TestEnableAbleRestfulAdapter
{
    use EnableAbleRestfulAdapterTrait;

    protected function getResource()
    {
        return 'news';
    }
}
