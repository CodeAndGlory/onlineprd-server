<?php

namespace App\Services;

use App\Models\Comment;
use Exception;
use Illuminate\Http\Request;

/**
 * Class CommentService
 * @package App\Services
 */
class CommentService extends APIService
{
    /**
     * CommentService constructor.
     * @param  Request  $request
     * @param  Comment  $comment
     * @throws Exception
     */
    public function __construct(Request $request, Comment $comment)
    {
        $this->setModel($comment);
        parent::__construct($request);
    }
}
