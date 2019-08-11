<?php
namespace Sdk\News\Adapter\News;

use Sdk\Common\Adapter\IEnableAbleAdapter;
use Sdk\Common\Adapter\IFetchAbleAdapter;
use Sdk\Common\Adapter\IOperatAbleAdapter;

use Marmot\Framework\Interfaces\IAsyncAdapter;

interface INewsAdapter extends IEnableAbleAdapter, IFetchAbleAdapter, IOperatAbleAdapter, IAsyncAdapter
{
}
