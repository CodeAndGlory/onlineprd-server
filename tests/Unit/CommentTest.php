<?php

namespace Tests\Unit;

use App\Models\Assignment;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;


    /*
     * Test the Comment->commentable method.
     *
     * @return void
     */
    public function testCommentCommentable()
    {
        $assignment = factory(Assignment::class)->create();
        $comment = factory(Comment::class)->create();
        $assignment->comments()->save($comment);

        $this->assertDatabaseHas('comments', [
            'id' => $comment->id,
            'commentable_id' => $assignment->id,
            'commentable_type' => 'App\\Models\\Assignment',
        ]);
    }

    /**
     * Test the Comment->user method.
     *
     * @return void
     */
    public function testCommentUserMethod()
    {
        $comment = factory(Comment::class)->create();
        $user = factory(User::class)->create();
        $comment->user()->associate($user);
        $comment->save();

        $this->assertDatabaseHas('comments', [
            'id' => $comment->id,
            'user_id' => $user->id,
        ]);
    }
}
