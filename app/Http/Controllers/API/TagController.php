<?php

namespace App\Http\Controllers\API;

use App\Services\TagService;

class TagController extends APIController
{
    public function __construct(TagService $service)
    {
        parent::__construct($service, 'tag');
    }
}
