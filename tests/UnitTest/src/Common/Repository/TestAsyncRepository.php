<?php
namespace Common\Repository;

use Marmot\Framework\Interfaces\IAsyncAdapter;

class TestAsyncRepository implements IAsyncAdapter
{
    use AsyncRepositoryTrait;
}
