<?php

namespace Tests\Unit\Services\Tracks\Models;

use App\Services\Tracks\Models\Track;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TrackTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function can_check_if_a_user_is_the_creator()
    {
        // Arrange
        $user = factory(User::class)->create();
        $otherUser = factory(User::class)->create();
        $track = factory(Track::class)->create(['creator_id' => $user->getKey()]);

        // Execute and Check
        $this->assertTrue($track->isCreator($user));
        $this->assertFalse($track->isCreator($otherUser));
    }
}
