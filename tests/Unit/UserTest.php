<?php

namespace Tests\Unit;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the User->comments method.
     *
     * @return void
     */
    public function testUserCommentsMethod()
    {
        $user = factory(User::class)->create();
        $user->comments()->save(factory(Comment::class)->create());

        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
        ]);
    }
}
