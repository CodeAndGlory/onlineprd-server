<?php

namespace App\Http\Controllers\API;

use App\Services\CommentService;

class CommentController extends APIController
{
    public function __construct(CommentService $service)
    {
        parent::__construct($service, 'comment');
    }
}
