<?php

namespace Tests\Feature\API\v1;

use App\Models\Comment;

class CommentControllerTest extends ControllerTestCase
{
    protected string $class = Comment::class;
    protected string $endpoint = 'comments';

    public function setUp(): void
    {
        parent::setUp();
        $this->model = new Comment();
    }
}
