<?php
namespace Common\Adapter;

class TestAsyncFetchAbleRestfulAdapter
{
    use AsyncFetchAbleRestfulAdapterTrait;

    protected function getResource()
    {
        return 'news';
    }
}
