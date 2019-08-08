<?php
namespace News\Adapter\News;

use Common\Adapter\IEnableAbleAdapter;
use Common\Adapter\IFetchAbleAdapter;
use Common\Adapter\IOperatAbleAdapter;

use Marmot\Framework\Interfaces\IAsyncAdapter;

interface INewsAdapter extends IEnableAbleAdapter, IFetchAbleAdapter, IOperatAbleAdapter, IAsyncAdapter
{
}
