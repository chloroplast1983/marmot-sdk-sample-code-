<?php
namespace Common\Adapter;

class TestFetchAbleRestfulAdapter
{
    use FetchAbleRestfulAdapterTrait;

    protected function getResource()
    {
        return 'news';
    }
}
