<?php

namespace Travelience\GraphQL\Facades;

use Illuminate\Support\Facades\Facade;

class GraphQL extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'graphql';
    }
}