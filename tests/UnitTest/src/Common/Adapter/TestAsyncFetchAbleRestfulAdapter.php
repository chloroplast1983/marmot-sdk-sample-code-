<?php
namespace Sample\Sdk\Common\Adapter;

class TestAsyncFetchAbleRestfulAdapter
{
    use AsyncFetchAbleRestfulAdapterTrait;

    protected function getResource()
    {
        return 'news';
    }
}
