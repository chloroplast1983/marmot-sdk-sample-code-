<?php
namespace Sample\Sdk\Common\Adapter;

class TestFetchAbleRestfulAdapter
{
    use FetchAbleRestfulAdapterTrait;

    protected function getResource()
    {
        return 'news';
    }
}
