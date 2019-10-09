<?php
namespace Sample\Sdk\Common\Repository;

use Marmot\Interfaces\IAsyncAdapter;

class TestAsyncRepository implements IAsyncAdapter
{
    use AsyncRepositoryTrait;
}
