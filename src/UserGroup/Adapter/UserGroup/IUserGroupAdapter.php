<?php
namespace Sample\Sdk\UserGroup\Adapter\UserGroup;

use Sample\Sdk\Common\Adapter\IFetchAbleAdapter;

use Marmot\Interfaces\IAsyncAdapter;
use Marmot\Interfaces\IErrorAdapter;

interface IUserGroupAdapter extends IFetchAbleAdapter, IAsyncAdapter, IErrorAdapter
{
}
