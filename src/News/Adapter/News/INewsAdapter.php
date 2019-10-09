<?php
namespace Sample\Sdk\News\Adapter\News;

use Sample\Sdk\Common\Adapter\IEnableAbleAdapter;
use Sample\Sdk\Common\Adapter\IFetchAbleAdapter;
use Sample\Sdk\Common\Adapter\IOperatAbleAdapter;

use Marmot\Interfaces\IAsyncAdapter;
use Marmot\Interfaces\IErrorAdapter;

interface INewsAdapter extends IEnableAbleAdapter, IFetchAbleAdapter, IOperatAbleAdapter, IAsyncAdapter, IErrorAdapter
{
}
